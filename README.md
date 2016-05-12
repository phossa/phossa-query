# phossa-query
[![Build Status](https://travis-ci.org/phossa/phossa-query.svg?branch=master)](https://travis-ci.org/phossa/phossa-query)
[![HHVM](https://img.shields.io/hhvm/phossa/phossa-query.svg?style=flat)](http://hhvm.h4cc.de/package/phossa/phossa-query)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa/phossa-query.svg?style=flat)](https://packagist.org/packages/phossa/phossa-query)
[![License](https://poser.pugx.org/phossa/phossa-query/license)](http://mit-license.org/)

**phossa-query** is a SQL query builder library with concise syntax for PHP.
It supports Mysql, SQLite, Postgres, Sql server, Oracle etc.

It requires PHP 5.4 and supports PHP 7.0+, HHVM. It is compliant with
[PSR-1][PSR-1], [PSR-2][PSR-2], [PSR-4][PSR-4].

[PSR-1]: http://www.php-fig.org/psr/psr-1/ "PSR-1: Basic Coding Standard"
[PSR-2]: http://www.php-fig.org/psr/psr-2/ "PSR-2: Coding Style Guide"
[PSR-4]: http://www.php-fig.org/psr/psr-4/ "PSR-4: Autoloader"

Installation
---

Install via the [`composer`](https://getcomposer.org/) utility.

```
composer require "phossa/phossa-query=1.*"
```

or add the following lines to your `composer.json`

```json
{
    "require": {
        "phossa/phossa-query": "^1.0.0"
    }
}
```

Usage
---

- Getting started

  Start with a query builder first, then the query.

  ```php
  use Phossa\Query\Builder;
  use Phossa\Query\Dialect\Mysql;

  // a builder with mysql dialect, some settings and default to 'users' table
  $users = new Builder('users', $settings, new Mysql());

  // SELECT * FROM `users` LIMIT 10
  $sql = $users->select()->limit(10)->getStatement();

  // INSERT INTO `users` (`usr_name`) VALUES ('phossa')
  $sql = $users->insert(['usr_name' => 'phossa'])->getStatement();

  // A new builder (cloned) with default table 'sales'
  $sales = $users->table(['sales' => 's']);
  $query = $sales->select()->where('user_id', 12);

  // SELECT * FROM `sales` AS `s` WHERE `user_id` = ?
  $sql = $query->getStatement(['positionedParam' => true]);

  // value bindings: [12]
  $val = $query->getBindings();
  ```

- `SELECT`

  - Columns

    Columns can be specified in the `select()` or in `col()` (or with its
    alias `field()`).

    Column with optional alias name,

    ```php
    // SELECT `user_name` AS `n` FROM `users`
    $query = $users->select('user_name', 'n');
    ```

    Multiple columns,

    ```php
    // SELECT `id`, `user_name` AS `n` FROM `users`
    $query = $users->select()->col(['id', 'user_name' => 'n']);

    // same as above
    $query = $users->select()->col('id')->field('user_name', 'n');
    ```

    Raw mode,

    ```php
    // SELECT COUNT(user_id) AS `cnt` FROM `users`
    $query = $users->select()->colRaw(['COUNT(user_id)' => 'cnt']);
    ```

    Common functions like `count()`, `min()`, `max()`, `avg()`, `sum()` and
    `sumDistinct()` can be used in the columns.

    ```php
    // SELECT COUNT(`user_id`) AS `cnt`, MAX(`user_id`) AS `max_id` FROM `users`
    $query = $users->select()->count('user_id', 'cnt')->max('user_id', 'max_id');
    ```

    Generic functions by using `func($template, $colName, $colAlias)`,

    ```php
    // SELECT CONCAT(`user_name`, "XXX") AS `new_name` FROM `users`
    $query = $users->select()->func('CONCAT(%s, "XXX")', 'user_name', 'new_name');
    ```

  - Distinct

    `DISTINCT` can be specified with `distinct()`

    ```php
    // SELECT DISTINCT `user_alias` FROM `users`
    $query = $users->select('user_alias')->distinct();
    ```

  - From

    `FROM` can used with builder object or select object.

    Use `select(false)` to ignore default table from the builder,

    ```php
    // SELECT * FROM `sales` AS `s`
    $query = $users->select(false)->from('sales', 's');
  ```

    Builder tables are carried over,

    ```php
    // SELECT * FROM `users`, `sales`
    $query = $users->select()->from('sales');
    ```

    Multiple tables (with aliases) supported,

    ```php
    // SELECT * FROM `users` AS `u`, `accounts` AS `a`
    $query = $users->select(false)->from(['users' => 'u', 'accounts' => 'a']);
    ```

    Subqueries can be used in `from()`,

    ```php
    // builder without default table[s]
    $builder = $users->table('');

    // SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`
    $query = $builder->select()->from(
        $builder->select('user_id')->from('oldusers'), 'u'
    );
    ```

  - Group by

    Single `GROUP BY`,

    ```php
    // SELECT `group_id`, COUNT(*) AS `cnt` FROM `users` GROUP BY `group_id`
    $query = $users->select()->col('group_id')->count('*', 'cnt')->groupBy('group_id');
    ```

    Multiple `groupBy()` and raw mode can be used,

    ```php
    // SELECT `group_id`, `age`, COUNT(*) AS `cnt` FROM `users` GROUP BY `group_id`, age ASC
    $query = $users->select()->col('group_id')->col('age')->count('*', 'cnt')
        ->groupBy('group_id')->groupByRaw('age ASC');
    ```

  - Join

    Join with another table with same column name

    ```php
    // SELECT * FROM `users` INNER JOIN `accounts` ON `users`.`id` = `accounts`.`id`
    $query = $users->select()->join('accounts', 'id');
    ```

    Specify alias for the join table,

    ```php
    // SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`
    $query = $users->select()->join('accounts a', 'id');
    ```

    Join table with different column name,

    ```php
    // SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`user_id`
    $query = $users->select()->join('accounts a', 'id', 'user_id');
    ```

    Join with operator specified,

    ```php
    // SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` <> `a`.`user_id`
    $query = $users->select()->join('accounts a', 'id', '<>', 'user_id');
    ```

    Join with complex `ON`,

    ```php
    $builder = $users->table('');

    // SELECT * FROM `users` INNER JOIN `sales` (ON `users`.`uid` = `sales`.`s_uid` OR `users`.`uid` = `sales`.`puid`)
    $sql = $users->select()->join('sales',
        $builder->expr()->on('users.uid', 'sales.s_uid')->orOn('users.uid', 'sales.puid')
    )->getStatement();
    ```

    Multiple joins,

    ```php
    // SELECT * FROM `users`
    // INNER JOIN `sales` AS `s` ON `users`.`uid` = `s`.`uid`
    // INNER JOIN `order` AS `o` ON `users`.`uid` = `o`.`o_uid`
    $query = $users->select()
                ->join('sales s', 'uid', '=', 'uid')
                ->join('order o', 'uid', 'o_uid')
                ->getStatement();
    ```

    Subqueries in join,

    ```php
    // SELECT * FROM `users` INNER JOIN (SELECT `uid` FROM `oldusers`) AS `x`
    // ON `users`.`uid` = `x`.`uid`
    $query = $users->select()->join(
        $builder->select('uid')->from('oldusers')->alias('x'),
        'uid'
    );
    ```

    Other joins `outerJoin()`, `leftJoin()`, `leftOuterJoin()`, `rightJoin()`,
    `rightOuterJoin()`, `fullOuterJoin()`, `crossJoin()` are supported. If want
    to use your own join, `realJoin()` is handy.

    ```php
    // SELECT * FROM `users` OUTER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`
    $query = $users->select()->outerJoin('accounts a', 'id');

    // SELECT * FROM `users` NATURAL JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`
    $query = $users->select()->realJoin('NATURAL', 'accounts a', 'id');
    ```

  - Limit

    `LIMIT` and `OFFSET` are supported,

    ```php
    // SELECT * FROM `users` LIMIT 30 OFFSET 10
    $query = $users->select()->limit(30, 10);

    // SELECT * FROM `users` LIMIT 20 OFFSET 15
    $query = $users->select()->limit(20)->offset(15);
    ```

    Or use `page($pageNum, $pageLength)`,

    ```php
    // SELECT * FROM `users` LIMIT 30 OFFSET 60
    $query = $users->select()->page(3, 30);
    ```

  - Order by

    Order by ASC or DESC

    ```php
    // SELECT * FROM `users` ORDER BY `age` ASC, `score` DESC
    $query = $users->select()->orderByAsc('age')->orderByDesc('score');
    ```

    Or raw mode

    ```php
    // SELECT * FROM `users` ORDER BY age ASC, score DESC
    $query = $users->select()->orderByRaw('age ASC, score DESC');
    ```

  - Where

    Simple wheres,

    ```php
    // SELECT * FROM `users` WHERE age > 18
    $query = $users->select()->where('age > 18');

    // SELECT * FROM `users` WHERE `age` = 18
    $query = $users->select()->where('age', 18);

    // SELECT * FROM `users` WHERE `age` < 18
    $query = $users->select()->where('age', '<', 18);
    ```

    Multiple wheres,

    ```php
    // SELECT * FROM `users` WHERE `age` > 18 AND `gender` = 'male'
    $query = $users->select()->where(['age' => ['>', 18], 'gender' => 'male']);

    // same as above
    $query = $users->select()->where('age', '>', 18)->where('gender','male');
    ```

    Complex where,

    ```php
    // SELECT * FROM `users` WHERE (`id` = 1 OR (`id` < 20 OR `id` > 100))
    // OR `name` = 'Tester'
    $query = $users->select()->where(
                $builder->expr()->where('id', 1)->orWhere(
                    $builder->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
                )
             )->orWhere('name', 'Tester');
    ```

    Raw mode,

    ```php
    // SELECT * FROM `users` WHERE age = 18 OR score > 90
    $query = $users->select()->whereRaw('age = 18')->orWhereRaw('score > 90');
    ```

    with `NOT`,

    ```php
    // SELECT * FROM `users` WHERE NOT `age` = 18 OR NOT `score` > 90
    $query = $users->select()->whereNot('age', 18)->orWhereNot('score', '>', 90);
    ```

    Where `IN` and `BETWEEN`

    ```php
    // SELECT * FROM `users` WHERE `age` IN (10,12,15,18,20) OR `score` NOT BETWEEN 90 AND 100
    $query = $users->select()->whereIn('age', [10,12,15,18,20])
            ->orWhereNotBetween('score', 90, 100);
    ```

    Where `IS NULL` and `IS NOT NULL`

    ```php
    // SELECT * FROM `users` WHERE `age` IS NULL OR `score` IS NOT NULL
    $query = $users->select()->whereNull('age')->orWhereNotNull('score');
    ```

    Exists,

    ```php
    $qry1  = $users->select('user_id')->where('age', '>', 60);
    $sales = $users->table('sales');

    // SELECT * FROM `sales` WHERE EXISTS (SELECT `user_id` FROM `users`
    // WHERE `age` > 60)
    $sql = $sales->select()->whereExists($qry1)->getStatement();
    ```

  - Having

    Similar to `WHERE` clause,

    ```php
    // SELECT * FROM `users` HAVING `age` = 10 OR `level` > 20
    $query = $users->select()->having('age', 10)->orHaving('level', '>', 20);
    ```

  - Union

    ```php
    // SELECT * FROM `users` UNION SELECT * FROM `oldusers1`
    // UNION ALL SELECT `user_id` FROM `oldusers2`
    $sql = $users->select()
            ->union()
                ->select()->from('oldusers1')
            ->unionAll()
                ->select('user_id')->from('oldusers2')
                ->getStatement()
    ```

- `INSERT`

  Single insert statement,

  ```php
  // INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa')
  $sql = $users->insert()->set('uid', 2)->set('uname', 'phossa')
      ->getStatement();

  // same as above, with array notation
  $sql = $users->insert()->set(['uid' => 2, 'uname' => 'phossa'])
      ->getStatement();
  ```

  Multiple data rows,

  ```php
  // INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa'), (3, 'test')
  $query = $users->insert()
            ->set(['uid' => 2, 'uname' => 'phossa'])
            ->set(['uid' => 3, 'uname' => 'test']);
  ```

  Insert with `DEFAULT` values

  ```php
  // INSERT INTO `users` (`uid`, `uname`, `phone`)
  // VALUES (2, 'phossa', DEFAULT), (3, 'test', '1234')
  $query = $users->insert([
      ['uid' => 2, 'uname' => 'phossa'],
      ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
  ]);
  ```

  Insert `NULL` instead of default values,

  ```php
  // INSERT INTO `users` (`uid`, `uname`, `phone`)
  // VALUES (2, 'phossa', NULL), (3, 'test', '1234')
  $sql = $query->getStatement(['useNullAsDefault' => true]);
  ```

  Insert with `SELECT` subquery,

  ```php
  // INSERT INTO `users` (`uid`, `uname`)
  // SELECT `user_id`, `user_name` FROM `oldusers`
  $query = $users->insert()->set(['uid', 'uname'])
               ->select(['user_id', 'user_name'])
               ->from('oldusers');
  ```

- `UPDATE`


Dependencies
---

- PHP >= 5.4.0

- phossa/phossa-shared 1.*

License
---

[MIT License](http://mit-license.org/)

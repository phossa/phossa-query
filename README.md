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

Features
--

- Support [SELECT](#select), [INSERT](#insert), [UPDATE](#update),
  [REPLACE](#replace), [DELETE](#delete), [CREATE TABLE](#create).

- Complex sql building with [expr()](#expr), [raw()](#raw), [before()](#before),
  [after()](#before) etc.

- Statement with positioned or named [parameters](#param).

- Beautiful output with different [settings](#settings).

- Ongoing support for different dialects like [`Mysql`](#mysql), `Sqlite` and
  more.

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

  // a builder with mysql dialect,default 'users' table
  $users = new Builder(new Mysql(), 'users');

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

- <a name="select"></a>`SELECT`

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
    $query = $users->select()->from(['users' => 'u', 'accounts' => 'a']);
    ```

    Subqueries can be used in `from()`,

    ```php
    // builder without default table[s]
    $builder = $users->table(false);

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

- <a name="insert"></a>`INSERT`

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

- <a name="update"></a>`UPDATE`

  Common update statement,

  ```php
  // UPDATE `users` SET `user_name` = 'phossa' WHERE `user_id` = 3
  $query = $users->update(['user_name' => 'phossa'])->where('user_id', 3);

  // UPDATE `users` SET `user_name` = 'phossa', `user_addr` = 'xxx'
  // WHERE `user_id` = 3
  $query = $users->update()->set('user_name','phossa')
      ->set('user_addr', 'xxx')->where('user_id', 3);
  ```

  With `Mysql` extensions,

  ```php
  // UPDATE IGNORE `users` SET `user_id` = user_id + 10 ORDER BY `user_id` ASC LIMIT 10
  $query = $users->update()->addHint('IGNORE')->set('user_id', $builder->raw('user_id + 10'))
      ->orderByASC('user_id')->limit(10);
  ```

- <a name="replace"></a>`REPLACE`

  Mysql version of replace,

  ```php
  // REPLACE LOW_PRIORITY INTO `users` (`user_id`, `user_name`) VALUES (3, 'phossa')
  $query = $users->replace(['user_id' => 3, 'user_name' => 'phossa'])
      ->addHint('low_priority');
  ```

  Sqlite version of replace,

  ```php
  // INSERT INTO `users` (`user_id`, `user_name`) VALUES (3, 'phossa')
  // ON CONFLICT REPLACE
  $query = $users->replace(['user_id' => 3, 'user_name' => 'phossa']);
  ```

- <a name="delete"></a>`DELETE`

  Single table deletion,

  ```php
  // DELETE FROM `users` WHERE `user_id` > 10 ORDER BY `user_id` ASC LIMIT 10
  $query = $users->delete()->where('user_id', '>', 10)
      ->orderByAsc('user_id')->limit(10);
  ```

  Multiple tables deletion

  ```php
  // DELETE `users`.* FROM `users` AS `u` INNER JOIN `accounts` AS `a`
  // ON `u`.`user_id` = `a`.`user_id` WHERE `a`.`total_amount` < 0
  $query = $users->delete('users')->from('users', 'u')
      ->join('accounts a', 'user_id')->where('a.total_amount', '<', 0);
  ```

- <a name="create"></a>`CREATE TABLE`

  Create table is used by most of the ORM libraries.

  ```php
  $builder = new Builder();

  $builder->create()->table('new_table')
      ->temp()
      ->ifNotExists()
      ->addCol('id', 'INT')
          ->notNull()
          ->autoIncrement()
      ->addCol('name', 'VARCHAR(20)')
          ->notNull()
          ->unique()
          ->defaultValue('NONAME')
      ->addCol('alias', 'VARCHAR(10)')
          ->colConstraint('CHECK ()')
      ->primaryKey(['id'])
      ->uniqueKey(['name(4) ASC', 'alias'], 'ON CONFLICT REPLACE')
      ->uniqueKey(['id', 'alias'], 'ON CONFLICT ROLLBACK')
      ->constraint('FOREIGN KEY (...)')
      ->tblOption('DELAY_KEY_WRITE=1')
      ->tblOption('MAX_ROWS=100')
      ->getStatement([
          'seperator' => "\n",
          'indent'    => "  ",
      ]);
  ```

  With the following output,

  ```sql
  CREATE TEMPORARY TABLE IF NOT EXISTS "new_table"
  (
    "id" INT NOT NULL AUTO_INCREMENT,
    "name" VARCHAR(20) NOT NULL DEFAULT 'NONAME' UNIQUE,
    "alias" VARCHAR(10) CHECK (),
    PRIMARY KEY ("id"),
    UNIQUE ("name"(4) ASC, "alias") ON CONFLICT REPLACE,
    UNIQUE ("id", "alias") ON CONFLICT ROLLBACK,
    FOREIGN KEY (...)
  )
    DELAY_KEY_WRITE=1,
    MAX_ROWS=100
  ```

Advanced topics
---
- <a name="expr"></a>`expr()`

  Expression can be used to construct complex `WHERE`

  ```php
  // SELECT
  //     *
  // FROM
  //     "Users"
  // WHERE
  //    ("age" < 18 OR "gender" = 'female')
  //    OR ("age" > 60 OR ("age" > 55 AND "gender" = 'female'))
  $query = $builder->select()->from('Users')->where(
      $builder->expr()->where('age', '<', 18)->orWhere('gender', 'female')
  )->orWhere(
      $builder->expr()->where('age', '>' , 60)->orWhere(
          $builder->expr()->where('age', '>', 55)->where('gender', 'female')
      )
  );
  ```

  Join with complex `ON`,

  ```php
  $builder = $users->table(false);

  // SELECT * FROM `users` INNER JOIN `sales`
  // (ON `users`.`uid` = `sales`.`s_uid` OR `users`.`uid` = `sales`.`puid`)
  $sql = $users->select()->join('sales',
      $builder->expr()->on('users.uid', 'sales.s_uid')->orOn('users.uid', 'sales.puid')
  )->getStatement();
  ```

- <a name="raw"></a>`raw()`

  Raw string bypass the quoting and escaping,

  ```php
  // SELECT id FROM "students" WHERE "time" = NOW()
  $query = $builder->select()->field($builder->raw("id"))
      ->from("students")->where("time", $builder->raw('NOW()'));
  ```

  Raw string with parameters,

  ```php
  // SELECT * FROM "students" WHERE "age" IN RANGE(1, 1.2)
  $query = $builder->select()->from("students")->where("age", "IN",
      $builder->raw('RANGE(?, ?)', 1, 1.2));
  ```

- <a name="before"></a>`before()` and `after()`

  Sometimes, non-standard SQL wanted and no methods found. `before()` and
  `after()` will come to rescue.

  ```php
  // INSERT IGNORE INTO "users" ("id", "name") VALUES (3, 'phossa')
  // ON DUPLICATE KEY UPDATE id=id+10
  $query = $users->insert()->set('id', 3)->set('name', 'phossa')
      ->before('INTO', 'IGNORE')
      ->after('VALUES', 'ON DUPLICATE KEY UPDATE id=id+?', 10);
  ```

- <a name="param"></a>Parameters

  *phossa-query* can return statement for driver to prepare and use the
  `getBindings()` to get the values to bind.

  ```php
  $query = $users->select()->where("user_id", 10);

  // SELECT * FROM "users" WHERE "user_id" = ?
  $sql = $query->getPositionedStatement();

  // values to bind: [10]
  $val = $query->getBindings();
  ```

  Or named parameters,

  ```php
  $query = $users->select()->where("user_name", ':name');

  // SELECT * FROM "users" WHERE "user_name" = :name
  $sql = $query->getNamedStatement();
  ```

- <a name="settings"></a>Settings

  Settings can be applied to `$builder` at instantiation,

  ```php
  $users = new Builder(new Mysql(), 'users', ['autoQuote' => false]);
  ```

  Or applied when output with `getStatement()`,

  ```php
  $sql = $users->select()->getStatement(['autoQuote' => false]);
  ```

  List of settings,

  - `autoQuote`: boolean. Quote db identifier or not.

  - `positionedParam`: boolean. Output with positioned parameter or not.

  - `namedParam`: boolean. Output with named parameter or not.

  - `seperator`: string, default to ' '. Seperator between clauses.

  - `indent`: string, default to ''. Indent prefix for clauses.

  - `escapeFunction`: callabel, default to `null`. Function used to quote and
    escape values.

  - `useNullAsDefault`: boolean.

Dialects
---

- <a name="mysql"></a>Mysql

Dependencies
---

- PHP >= 5.4.0

- phossa/phossa-shared 1.*

License
---

[MIT License](http://mit-license.org/)

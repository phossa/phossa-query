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

  Columns can be specified in the `select()` or with `col()` (or with its
  alias `field()`).

  ```php
  // SELECT `user_name` AS `n` FROM `users`
  $query = $users->select('user_name', 'n');

  // SELECT `id`, `user_name` AS `n` FROM `users`
  $query = $users->select()->col(['id', 'user_name' => 'n']);
  $query = $users->select()->col('id')->field('user_name', 'n');

  // SELECT COUNT(user_id) AS `cnt` FROM `users`
  $query = $users->select()->colRaw(['COUNT(user_id)' => 'cnt']);
  ```

  Common functions like `count()`, `min()`, `max()`, `avg()`, `sum()` and
  `sumDistinct()` can be used in the columns.

  ```php
  // SELECT COUNT(`user_id`) AS `cnt` FROM `users`
  $query = $users->select()->count('user_id', 'cnt')->max('user_id', 'max_id');

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

  ```php
  /*
   * `select(false)` if don't want use the builder default tables
   *
   * SELECT * FROM `sales` AS `s`
   */
  $query = $users->select(false)->from('sales', 's');

  // SELECT * FROM `users`, `sales`
  $query = $users->select()->from('sales');

  // SELECT * FROM `users` AS `u`, `accounts` AS `a`
  $query = $users->select(false)->from(['users' => 'u', 'accounts' => 'a']);

  // SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`
  $builder = $users->table(''); // clear table
  $query = $builder->select()->from($builder->select('user_id')->from('oldusers'), 'u');
  ```

Dependencies
---

- PHP >= 5.4.0

- phossa/phossa-shared 1.*

License
---

[MIT License](http://mit-license.org/)

# phossa-query
[![Build Status](https://travis-ci.org/phossa/phossa-query.svg?branch=master)](https://travis-ci.org/phossa/phossa-query)
[![HHVM](https://img.shields.io/hhvm/phossa/phossa-query.svg?style=flat)](http://hhvm.h4cc.de/package/phossa/phossa-query)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa/phossa-query.svg?style=flat)](https://packagist.org/packages/phossa/phossa-query)
[![License](https://poser.pugx.org/phossa/phossa-query/license)](http://mit-license.org/)

**phossa-query** is a SQL query builder for PHP.

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

  Create a query builder first, then the query.

  ```php
  // a user table related builder
  $user = new Builder('Users');

  // SELECT * FROM `Users` LIMIT 0, 10
  $sql  = $user->select()->limit(10)->getStatement();

  // INSERT INTO `Users` ('usr_name') VALUES ('phossa')
  $sql  = $user->insert('usr_name' => 'phossa')->getStatement();

  // switch to another table
  $sale = $user->table('Sale');

  // SELECT * FROM `Sale` LIMIT 0, 10
  $sql  = $sale->select()->limit(10)->getStatement();
  ```

- `SELECT`

  ```php

  ```

Dependencies
---

- PHP >= 5.4.0

- phossa/phossa-shared 1.*

License
---

[MIT License](http://mit-license.org/)

<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

$sql = 'SELECT __1__, __2__ FROM users WHERE user_id = __3__';
var_dump(preg_replace_callback(
    '/\b__[0-9]+__\b/',
    function($m) {
        var_dump($m);
        return 'xx';
    }, $sql)
);

class A {}
var_dump(spl_object_hash(new A()));

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



function param($template) {
    // get values from argument list
    $val = func_get_args();
    array_shift($val);

    // replace
    $pat = $rep = [];
    foreach ($val as $v) {
        $pat[] = '/\?/';
        $rep[] = generate($v);
    }
    var_dump(preg_replace($pat, $rep, $template, 1));
}

function generate($value)
{
    static $count = 0, $params = [];

    $key = '__P_' . ++$count . '__';
    $params[$key] = $value;
    var_dump($params);

    return $key;
}

$str = 'IN (?, ?, ?, ?, ?, ?)';
param($str, 1,2,3,a,b,c);

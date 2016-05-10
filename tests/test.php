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

class A {
    protected $config = [ 'a' => 1 ];

    public function getConfig() {
        var_dump($this->config);
    }
}

class B extends A {
    protected $config = [ 'b' => 2 ];

    public function getConfig() {
        var_dump(array_merge(parent::$config, $this->config));
    }
}

var_dump((new B())->getConfig());

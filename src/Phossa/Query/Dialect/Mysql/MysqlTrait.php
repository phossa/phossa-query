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

namespace Phossa\Query\Dialect\Mysql;

/**
 * MysqlTrait
 *
 * Common stuff for Mysql
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     MysqlInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait MysqlTrait
{
    /**
     * {@inheritDoc}
     */
    protected function getConfig()/*# : array */
    {
        $config = array_replace($this->config, $this->my_config);
        ksort($config);
        return $config;
    }
}

<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql;

use Phossa\Query\Driver;

/**
 * Query output related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryInterface
{
    /**
     * Return the statement for $driver
     *
     * @param  string $tablePrefix (optional) prefix to table
     * @param  Driver\DriverInterface $driver (optional) specific driver
     * @return string
     * @access public
     * @api
     */
    public function getStatement(
        /*# string */ $tablePrefix = '',
        Driver\DriverInterface $driver = null
    )/*# : string */;

    /**
     * Return binding values
     *
     * @param  void
     * @return array
     * @access public
     * @api
     */
    public function getBindings()/*# : array */;

    /**
     * Return the query string
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function __toString()/*# string */;
}

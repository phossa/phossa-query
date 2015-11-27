<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Driver;

/**
 * DriverCapableInterface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DriverCapableInterface
{
    /**
     * Set the driver
     *
     * @param  DriverInterface $driver specific driver
     * @return this
     * @access public
     * @api
     */
    public function setDriver(
        DriverInterface $driver
    );

    /**
     * Get the driver. if not set, return a new Common driver
     *
     * @param  void
     * @return DriverInterface
     * @access public
     * @api
     */
    public function getDriver()/*# : DriverInterface */;
}

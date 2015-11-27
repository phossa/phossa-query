<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * BuilderOption interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Query\Driver\DriverCapableInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderOptionInterface extends Driver\DriverCapableInterface
{
    /**
     * Set current query builder mode
     *
     * @param  int $mode mode to set
     * @return this
     * @access public
     */
    public function setQueryMode(
        /*# int */ $mode
    )/*# : BuilderOptionInterface */;

    /**
     * Get current query builder mode
     *
     * @param  void
     * @return int
     * @access public
     */
    public function getQueryMode()/*# : int */;

    /**
     * Set the table prefix
     *
     * @param  string $prefix the prefix string
     * @return this
     * @access public
     * @api
     */
    public function setTablePrefix(
        /*# string */ $prefix
    )/*# : BuilderOptionInterface */;

    /**
     * Get the table prefix
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function getTablePrefix()/*# : string */;
}

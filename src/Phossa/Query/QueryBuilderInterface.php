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
 * QueryBuilder interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryBuilderInterface extends QueryInterface
{
    /**
     * Get current query builder mode
     *
     * @param  void
     * @return int
     * @access public
     */
    public function getMode()/*# : int */;

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
    )/*# : QueryBuilderInterface */;

    /**
     * Get the table prefix
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function getTablePrefix()/*# : string */;

    /**
     * Select query
     *
     * @param  string|array variable parameters
     * @return Select\SelectQueryInterface
     * @see    Select\SelectInterface::select()
     * @access public
     * @api
     */
    public function select()/*# : Select\SelectQueryInterface */;
}

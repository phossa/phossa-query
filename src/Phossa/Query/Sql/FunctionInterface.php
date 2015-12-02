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

/**
 * SQL function related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FunctionInterface
{
    /**
     * Count function
     *
     * @param  string $colSpec column specification
     * @return this
     * @access public
     * @api
     */
    public function count(
        /*# string */ $colSpec
    )/*# : SelectQueryInterface */;

    /**
     * Max function
     *
     * @param  string $colSpec column specification
     * @return this
     * @access public
     * @api
     */
    public function max(
        /*# string */ $colSpec
    )/*# : SelectQueryInterface */;

    /**
     * Min function
     *
     * @param  string $colSpec column specification
     * @return this
     * @access public
     * @api
     */
    public function min(
        /*# string */ $colSpec
    )/*# : SelectQueryInterface */;

    /**
     * Sum function
     *
     * @param  string $colSpec column specification
     * @return this
     * @access public
     * @api
     */
    public function sum(
        /*# string */ $colSpec
    )/*# : SelectQueryInterface */;

    /**
     * Avg function
     *
     * @param  string $colSpec column specification
     * @return this
     * @access public
     * @api
     */
    public function avg(
        /*# string */ $colSpec
    )/*# : SelectQueryInterface */;
}

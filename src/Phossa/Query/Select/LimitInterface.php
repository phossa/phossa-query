<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Select;

/**
 * Limit clause related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface LimitInterface
{
    /**
     * Limit clause
     *
     * @param  int $limit limit number
     * @param  int $offset (optional) offset position
     * @return this
     * @access public
     * @api
     */
    public function limit(
        /*# int */ $limit,
        /*# int */ $offset = 0
    )/*# : SelectQueryInterface */;

    /**
     * Set offset, starts from 0
     *
     * @param  int $offset offset number
     * @return this
     * @access public
     * @api
     */
    public function offset(
        /*# int */ $offset
    )/*# : SelectQueryInterface */;

    /**
     * View by page, page number start from 1
     *
     * @param  int $page (optional) page number
     * @param  int $rows (optional) rows per page
     * @return this
     * @access public
     * @api
     */
    public function page(
        /*# int */ $page = 1,
        /*# int */ $rows = 100
    )/*# : SelectQueryInterface */;

    /**
     * Set per page rows
     *
     * @param  int $rows rows per page
     * @return this
     * @access public
     * @api
     */
    public function setPerPage(
        /*# int */ $rows
    )/*# : SelectQueryInterface */;

    /**
     * Get per page rows
     *
     * @param  void
     * @return int
     * @access public
     * @api
     */
    public function getPerPage()/*# : int */;
}

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

namespace Phossa\Query\Statement\Clause;

/**
 * OrderByInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OrderByInterface
{
    /**
     * Generic ORDER BY DESC
     *
     * ```php
     * // ORDER BY `year` DESC
     * ->orderByDesc('year')
     * ```
     *
     * @param  string $col
     * @param  bool $rawMode
     * @param  string $desc 'DESC' or 'ASC'
     * @return self
     * @access public
     */
    public function orderByDesc(
        /*# string */ $col,
        /*# bool */ $rawMode = false,
        /*# sting */ $desc = 'DESC'
    );

    /**
     * Generic ORDER BY ASC
     *
     * ```php
     * // ORDER BY `year` ASC
     * ->orderByAsc('year')
     * ```
     *
     * @param  string $col
     * @return self
     * @access public
     */
    public function orderByAsc(/*# string */ $col);

    /**
     * Raw mode ORDER BY
     *
     * ```php
     * // ORDER BY col NULLS LAST DESC
     * ->orderByRaw('col NULLS LAST DESC')
     * ```
     *
     * @param  string $orderby
     * @return self
     * @access public
     */
    public function orderByRaw(/*# string */ $orderby);
}

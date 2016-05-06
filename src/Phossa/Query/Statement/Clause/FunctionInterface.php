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
 * FunctionInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FunctionInterface
{
    /**
     * Function used in column field
     *
     * @param  string $function
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function func(
        /*# string */ $function,
        /*# string */ $col,
        /*# string */ $alias = ''
    );

    /**
     * COUNT()
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function count(/*# string */ $col, /*# string */ $alias = '');

    /**
     * MIN()
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function min(/*# string */ $col, /*# string */ $alias = '');

    /**
     * MAX()
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function max(/*# string */ $col, /*# string */ $alias = '');

    /**
     * AVG()
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function avg(/*# string */ $col, /*# string */ $alias = '');

    /**
     * SUM()
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function sum(/*# string */ $col, /*# string */ $alias = '');

    /**
     * SUM(DISTINCT)
     *
     * @param  string $col
     * @param  string $alias
     * @return $this
     * @access public
     */
    public function sumDistinct(/*# string */ $col, /*# string */ $alias = '');
}

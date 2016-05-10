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

namespace Phossa\Query\Clause;

/**
 * LimitInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface LimitInterface extends ClauseInterface
{
    /**
     * Limit return rows, if $count is -1, means to the end
     *
     * @param  int $count
     * @return self
     * @access public
     */
    public function limit(/*# int */ $count, /*# int */ $offset = 0);

    /**
     * Offset
     *
     * @param  int $offset
     * @return self
     * @access public
     */
    public function offset(/*# int */ $offset);

    /**
     * Paging
     *
     * @param  int $pageNumber start from 1
     * @param  int $perPage rows per page
     * @return self
     * @access public
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30);
}

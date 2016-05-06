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

use Phossa\Query\Exception\InvalidArgumentException;
/**
 * BeforeAfterInterface
 *
 * Insert before/after some position in the query. Used primary for different
 * dialect extension such as Mysql etc.
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BeforeAfterInterface
{
    /**
     * Insert clause before some position like before 'WHERE'
     *
     * ```php
     * // insert PARTITION before WHERE
     * ->before('where', 'PARTITION (part1, part2)')
     * ```
     *
     * @param  string $position such as 'where'
     * @param  string $clause the clause to insert
     * @return $this
     * @throws InvalidArgumentException if position unknown
     * @access public
     */
    public function before(
        /*# string */ $position,
        /*# string */ $clause
    );

    /**
     * Insert clause after some position like after 'LIMIT'
     *
     * ```php
     * // insert PROCEDURE after LIMIT
     * ->after('limit', 'PROCEDURE ....')
     * ```
     *
     * @param  string $position such as 'where'
     * @param  string $clause the clause to insert
     * @return $this
     * @throws InvalidArgumentException if position unknown
     * @access public
     */
    public function after(
        /*# string */ $position,
        /*# string */ $clause
    );
}

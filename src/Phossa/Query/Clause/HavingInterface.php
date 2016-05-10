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
 * HavingInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface HavingInterface extends ClauseInterface
{
    /**
     * Generic HAVING
     *
     * ```php
     * // HAVING `count` = 10
     * ->having('count', 10)
     *
     * // HAVING `count` > 10
     * ->having('count', '>', 10)
     *
     * // auto raw mode
     * ->having('count > 10')
     * ```
     *
     * @param  string $col
     * @param  string $operator
     * @param  mixed $value
     * @param  bool $logicAnd 'AND'
     * @return self
     * @access public
     */
    public function having(
        /*# string */ $col,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $value = ClauseInterface::NO_VALUE,
        /*# bool */ $logicAnd = true
    );

    /**
     * OR HAVING
     *
     * @param  string $col
     * @param  string $operator
     * @param  mixed $value
     * @return self
     * @access public
     */
    public function orHaving(
        /*# string */ $col,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $value = ClauseInterface::NO_VALUE
    );

    /**
     * Raw mode Having
     *
     * @param  string $having
     * @return self
     * @access public
     */
    public function havingRaw(/*# string */ $having);

    /**
     * Raw mode OR Having
     *
     * @param  string $having
     * @return self
     * @access public
     */
    public function orHavingRaw(/*# string */ $having);
}

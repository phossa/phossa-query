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
 * HavingInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface HavingInterface
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
     * ```
     *
     * @param  string $col
     * @param  string $operator
     * @param  mixed $value
     * @param  bool $rawMode
     * @return $this
     * @access public
     */
    public function having(
        /*# string */ $col,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $value = WhereInterface::NO_VALUE,
        /*# bool */ $rawMode = false
    );

    /**
     * Raw mode HAVING
     *
     * ```php
     * // HAVING count > 10
     * ->havingRaw('count > 10')
     * ```
     *
     * @param  string $having
     * @return $this
     * @access public
     */
    public function havingRaw(/*# string */ $having);
}

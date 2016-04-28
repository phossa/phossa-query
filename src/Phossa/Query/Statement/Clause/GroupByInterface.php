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
 * GroupByInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface GroupByInterface
{
    /**
     * Generic GROUP BY
     *
     * ```php
     * // GROUP BY `year`
     * ->groupBy('year')
     * ```
     *
     * @param  string $col
     * @param  bool $rawMode
     * @return $this
     * @access public
     */
    public function groupBy(/*# string */ $col, /*# bool */ $rawMode = false);

    /**
     * Generic GROUP BY Raw mode
     *
     * ```php
     * // GROUP BY year WITH ROLLUP
     * ->groupByRaw('year WITH ROLLUP')
     * ```
     *
     * @param  string $groupby
     * @return $this
     * @access public
     */
    public function groupByRaw(/*# string */ $groupby);
}

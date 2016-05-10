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
 * GroupByInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface GroupByInterface extends ClauseInterface
{
    /**
     * Generic GROUP BY
     *
     * ```php
     * // GROUP BY `year`
     * ->groupBy('year')
     * ```
     *
     * @param  string|array $col
     * @param  bool $rawMode
     * @return self
     * @access public
     */
    public function groupBy($col, /*# bool */ $rawMode = false);

    /**
     * Generic GROUP BY Raw mode
     *
     * ```php
     * // GROUP BY year WITH ROLLUP
     * ->groupByRaw('year WITH ROLLUP')
     * ```
     *
     * @param  string $groupby
     * @return self
     * @access public
     */
    public function groupByRaw(/*# string */ $groupby);
}

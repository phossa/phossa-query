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
 * GroupByTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     GroupByInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait GroupByTrait
{
    /**
     * {@inheritDoc}
     */
    public function groupBy(/*# string */ $col, /*# bool */ $rawMode = false)
    {
        $this->clauses['groupby'][] = [$rawMode, $col];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function groupByRaw(/*# string */ $groupby)
    {
        return $this->groupBy($groupby, true);
    }
}

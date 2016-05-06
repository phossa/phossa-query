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
    public function groupBy($col, /*# bool */ $rawMode = false)
    {
        if (is_array($col)) {
            foreach ($col as $c) {
                $this->groupBy($c, $rawMode);
            }
        } else {
            $this->clauses['groupby'][] = [
                $rawMode ?: $this->isRaw($col), $col
            ];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function groupByRaw(/*# string */ $groupby)
    {
        return $this->groupBy($groupby, true);
    }

    /**
     * Build GROUP BY
     *
     * @return array
     * @access protected
     */
    protected function buildGroupBy()/*# : array */
    {
        $result = [];
        if (isset($this->clauses['groupby'])) {
            foreach ($this->clauses['groupby'] as $grp) {
                $result[] = $grp[0] ? $grp[1] : $this->quote($grp[1]);
            }
        }
        return $result;
    }

    abstract protected function isRaw(/*# string */ $string)/*# : bool */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

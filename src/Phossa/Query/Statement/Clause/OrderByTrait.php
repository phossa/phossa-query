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
 * OrderByTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OrderByInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait OrderByTrait
{
    /**
     * {@inheritDoc}
     */
    public function orderByDesc(
        /*# string */ $col,
        /*# bool */ $rawMode = false,
        /*# sting */ $desc = 'DESC'
    ) {
        $this->clauses['orderby'][] = [
            $rawMode ?: $this->isRaw($col), $col, $desc
        ];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function orderByAsc(/*# string */ $col)
    {
        return $this->orderByDesc($col, false, 'ASC');
    }

    /**
     * {@inheritDoc}
     */
    public function orderByRaw(/*# string */ $orderby)
    {
        return $this->orderByDesc($orderby, true);
    }

    /**
     * Build ORDER BY
     *
     * @return array
     * @access protected
     */
    protected function buildOrderBy()/*# : array */
    {
        $result = [];
        if (isset($this->clauses['orderby'])) {
            foreach ($this->clauses['orderby'] as $ord) {
                $result[] = $ord[0] ? $ord[1] :
                    ($this->quote($ord[1]) . ' ' . $ord[2]);
            }
        }
        return $result;
    }

    abstract protected function isRaw(/*# string */ $string)/*# : bool */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

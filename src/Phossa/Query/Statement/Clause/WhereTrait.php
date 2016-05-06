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

use Phossa\Query\Statement\SelectInterface;
use Phossa\Query\Statement\ExpressionInterface;
use Phossa\Query\Statement\StatementInterface;
use Phossa\Query\Statement\RawInterface;

/**
 * WhereTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OtherWhereInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait WhereTrait
{
    /**
     * {@inheritDoc}
     */
    public function where(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false,
        /*# string */ $clause = 'where'
    ) {
        // $col is an array
        if (is_array($col)) {
            foreach ($col as $fld => $val) {
                $this->where(
                    $fld, $val, self::NO_VALUE, $logicAnd, $whereNot, $rawMode
                );
            }

        // $col is string or object
        } else {
            // grouped where
            if (is_object($col) && $col instanceof ExpressionInterface) {
                $operator = null;
                $value    = null;

            // 1 param provided, raw where provided
            } elseif (WhereInterface::NO_OPERATOR === $operator) {
                $rawMode  = true;
                $operator = null;
                $value    = null;

            //  2 params provided
            } elseif (WhereInterface::NO_VALUE === $value) {
                if (is_array($operator)) {
                    $value    = $operator[1];
                    $operator = $operator[0];
                } else {
                    $value    = $operator;
                    $operator = '=';
                }

            // short version provided
            } elseif (WhereInterface::SHORT_FORM === $value) {
                $value = null;
            }

            $this->clauses[$clause][] = [
                $rawMode, $whereNot, $logicAnd, $col, $operator, $value
            ];
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function andWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE
    ) {
        return $this->where($col, $operator, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhere(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE
    ) {
        return $this->where($col, $operator, $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereRaw($where)
    {
        return $this->where($where, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, true, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereRaw($where)
    {
        return $this->where($where, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, false, false, true
        );
    }

    /**
     * {@inheritDoc}
     */
    public function whereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE
    ) {
        return $this->where($col, $operator, $value, true, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNot(
        $col,
        $operator = WhereInterface::NO_OPERATOR,
        $value    = WhereInterface::NO_VALUE
    ) {
        return $this->where($col, $operator, $value, false, true);
    }

    /**
     * {@inheritDoc
     */
    public function whereIn($col, array $value, $and = true, $not = false)
    {
        $in = ($not ? 'NOT IN (' : 'IN (') . join(',', $value) . ')';
        return $this->where($col, $in, WhereInterface::SHORT_FORM, $and);
    }

    /**
     * {@inheritDoc
     */
    public function orWhereIn($col, array $value)
    {
        return $this->whereIn($col, $value, false);
    }

    /**
     * {@inheritDoc
     */
    public function whereNotIn($col, array $value)
    {
        return $this->whereIn($col, $value, true, true);
    }

    /**
     * {@inheritDoc
     */
    public function orWhereNotIn($col, array $value)
    {
        return $this->whereIn($col, $value, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function whereBetween($col, $val1, $val2, $and = true, $not = false)
    {
        $bet = sprintf('%sBETWEEN %s AND %s', $not ? 'NOT ' : '', $val1, $val2);
        return $this->where($col, $bet, WhereInterface::SHORT_FORM, $and);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereBetween($col, $value1, $value2)
    {
        return $this->whereBetween($col, $value1, $value2, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotBetween($col, $value1, $value2)
    {
        return $this->whereBetween($col, $value1, $value2, true, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotBetween($col, $val1, $val2)
    {
        return $this->whereBetween($col, $val1, $val2, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNull($col, $and = true, $not = false)
    {
        return $this->where($col, $not ? 'IS NOT NULL' : 'IS NULL',
            WhereInterface::SHORT_FORM, $and);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNull($col)
    {
        return $this->whereNull($col, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotNull($col)
    {
        return $this->whereNull($col, true, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotNull($col)
    {
        return $this->whereNull($col, false, true);
    }

    /**
     * {@inheritDoc}
     */
    public function whereExists(
        SelectInterface $sel, $and = true, $not = false
    ) {
        $ext = $not ? 'NOT EXISTS' : 'EXISTS';
        return $this->where(null, $ext, $sel, $and);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereExists(SelectInterface $sel)
    {
        return $this->whereExists($sel, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotExists(SelectInterface $sel)
    {
        return $this->whereExists($sel, true, true);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotExists(SelectInterface $sel)
    {
        return $this->whereExists($sel, false, true);
    }

    /**
     * Build WHERE
     *
     * @param  string $clause 'where|having'
     * @return array
     * @access protected
     */
    protected function buildWhere(/*# string */ $clause = 'where')/*# : array */
    {
        $result = [];
        if (!empty($this->clauses[$clause])) {
            // $rawMode, $whereNot, $logicAnd, $col, $operator, $value
            foreach ($this->clauses[$clause] as $idx => $where) {
                $cls = [];

                // AND OR
                if ($idx) {
                    $cls[] = $where[2] ? 'AND' : 'OR';
                }

                // NOT
                if ($where[1]) {
                    $cls[] = 'NOT';
                }

                // grouped where
                if (is_object($where[3])) {
                    $cls[] = $where[3]->getSql([], $this->getDialect(), false);

                } elseif (!is_null($where[3])) {
                    $cls[] = $where[0] ? $where[3] : $this->quote($where[3]);
                }

                // operator
                if (!is_null($where[4])) {
                    $cls[] = (empty($col) ? '' : ' ') . $where[4];
                }

                // val part
                if (is_object($where[5])) {
                    // subquery (SELECT ...)
                    if ($where[5] instanceof StatementInterface) {
                        $cls[] = '(' . $where[5]->getSql([],
                            $this->getDialect(), false) .')';
                    } elseif ($where[5] instanceof RawInterface) {
                        $cls[] = $where[5] . '';
                    }
                } elseif (!is_null($where[5])) {
                    $cls[] = $this->getPlaceholder($where[5]);
                }

                $result[] = join(' ', $cls);
            }
        }
        return $result;
    }

    abstract public function getDialect()/*# : DialectInterface */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
    abstract protected function getPlaceholder($value)/*# : string */;
}

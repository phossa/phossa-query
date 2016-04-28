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

use Phossa\Query\Statement\StatementInterface;

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
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false
    ) {
        // grouped () where
        if (is_object($col) && $col instanceof StatementInterface) {
            $xwhere = $col->getClauses()['where'];
            $this->clauses['where'][] = [$xwhere];

        // array
        } elseif (is_array($col)) {
            foreach ($col as $fld => $val) {
                $this->where(
                    $col, $val, self::NO_VALUE, $logicAnd, $whereNot, $rawMode
                );
            }

        // string
        } elseif (is_string($col)) {

            // 1 param provided, raw where provided
            if (WhereInterface::NO_OPERATOR === $operator) {
                $rawMode = true;

            //  2 params provided
            } elseif (WhereInterface::NO_VALUE === $value) {
                if (is_array($operator)) {
                    $value = $operator[1];
                    $operator = $operator[0];
                } else {
                    $value = $operator;
                    $operator = '=';
                }
            }

            $this->clauses['where'][] = [
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
        return $this->where(
            $where,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            true,
            false,
            true
        );
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereRaw($where)
    {
        return $this->where(
            $where,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            false,
            false,
            true
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
    public function whereIn($col, array $value)
    {
        return $this->where($col, 'IN', $value);
    }

    /**
     * {@inheritDoc
     */
    public function orWhereIn($col, array $value)
    {
        return $this->where($col, 'IN', $value, false);
    }

    /**
     * {@inheritDoc
     */
    public function whereNotIn($col, array $value)
    {
        return $this->where($col, 'NOT IN', $value);
    }

    /**
     * {@inheritDoc
     */
    public function orWhereNotIn($col, array $value)
    {
        return $this->where($col, 'NOT IN', $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereBetween($col, $value1, $value2)
    {
        return $this->where($col, 'BETWEEN', [$value1, $value2]);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereBetween($col, $value1, $value2)
    {
        return $this->where($col, 'BETWEEN', [$value1, $value2], false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotBetween($col, $value1, $value2)
    {
        return $this->where($col, 'NOT BETWEEN', [$value1, $value2]);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotBetween($col, $value1, $value2)
    {
        return $this->where($col, 'NOT BETWEEN', [$value1, $value2], false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNull($col)
    {
        return $this->where($col, 'IS', null);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNull($col)
    {
        return $this->where($col, 'IS', null, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotNull($col)
    {
        return $this->where($col, 'IS NOT', null);
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotNull($col)
    {
        return $this->where($col, 'IS NOT', null, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereExists($col)
    {
        return $this->where($col, 'EXISTS');
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereExists($col)
    {
        return $this->where($col, 'EXISTS', null, false);
    }

    /**
     * {@inheritDoc}
     */
    public function whereNotExists($col)
    {
        return $this->where($col, 'NOT EXISTS');
    }

    /**
     * {@inheritDoc}
     */
    public function orWhereNotExists($col)
    {
        return $this->where($col, 'NOT EXISTS', null, false);
    }
}

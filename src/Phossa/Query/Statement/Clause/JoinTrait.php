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

/**
 * JoinTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     JoinInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait JoinTrait
{
    /**
     * {@inheritDoc}
     */
    public function join(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# string */ $joinType = 'INNER',
        /*# bool */ $rawMode = false
    ) {
        $join = $joinType . ' JOIN';

        // raw
        if ($rawMode) {
            $this->clauses['join'] = [$rawMode, $table];
            return $this;

        // groupd on/orOn
        } elseif (is_object($firstTableCol) &&
            $firstTableCol instanceof SelectInterface
        ) {
            $on = $firstTableCol;
        } else {
            $or = false;
            if (WhereInterface::NO_OPERATOR === $operator) {
                $on = [$or, $firstTableCol, '=', $firstTableCol];
            } elseif (WhereInterface::NO_VALUE === $secondTableCol) {
                $on = [$or, $firstTableCol, '=', $operator];
            } else {
                $on = [$or, $firstTableCol, $operator, $secondTableCol];
            }
        }
        $this->clauses['join'] = [$rawMode, $join, $table, $on];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function innerJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join($table, $firstTableCol, $operator, $secondTableCol);
    }

    /**
     * {@inheritDoc}
     */
    public function outerJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'OUTER'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function leftJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'LEFT'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function leftOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'LEFT OUTER'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function rightJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'RIGHT'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function rightOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'RIGHT OUTER'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function fullOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'FULL OUTER'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function crossJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->join(
            $table, $firstTableCol, $operator, $secondTableCol, 'CROSS'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function joinRaw(/*# string */ $join)
    {
        return $this->join($join, '', '', '', '', true);
    }

    /**
     * {@inheritDoc}
     */
    public function on(
        /*# string */ $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# bool */ $or = false
    ) {
        if (WhereInterface::NO_OPERATOR === $operator) {
            $on = [$or, $firstTableCol, '=', $firstTableCol];
        } elseif (WhereInterface::NO_VALUE === $secondTableCol) {
            $on = [$or, $firstTableCol, '=', $operator];
        } else {
            $on = [$or, $firstTableCol, $operator, $secondTableCol];
        }
        $this->clauses['on'] = $on;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function orOn(
        /*# string */ $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->on(
            $firstTableCol, $operator, $secondTableCol, true
        );
    }
}

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
     * JOINs
     *
     * @var    array
     * @access protected
     */
    protected $clause_join = [];

    /**
     * {@inheritDoc}
     */
    public function realJoin(
        /*# string */ $joinType,
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# bool */ $rawMode = false
    ) {
        $join = strtoupper($joinType) . ' JOIN';

        // raw mode
        if ($rawMode || '' === $firstTableCol) {
            $rawMode = true;
            $on = null;

        // groupd on/orOn
        } elseif (is_object($firstTableCol) &&
                $firstTableCol instanceof ExpressionInterface
        ) {
            // object ExpressionInterface
            $on = $firstTableCol;

        } elseif ($this->isRaw($firstTableCol)) {
            $rawMode = true;

            // raw string
            $on = $firstTableCol;

        // col provided
        } else {
            // only ONE colName provided
            if (WhereInterface::NO_OPERATOR === $operator) {
                $on = [$firstTableCol, '=', $firstTableCol];

            // 2 colNames provides
            } elseif (WhereInterface::NO_VALUE === $secondTableCol) {
                $on = [$firstTableCol, '=', $operator];

            // 2 colNames and operator provided
            } else {
                $on = [$firstTableCol, $operator, $secondTableCol];
            }
        }

        // check table alias
        if (is_object($table) && $table instanceof SelectInterface) {
            // subquery MUST have alias
            $alias = $table->getAlias();
        } else {
            // find alias in the $table
            $splitted = $this->splitAlias($table);
            if (!$rawMode && isset($splitted[1])) {
                $table = $splitted[0];
                $alias = $splitted[1];
            } else {
                $alias = null;
            }
        }

        $this->clause_join[] = [$rawMode, $join, $table, $on, $alias];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function join(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
        ) {
            return $this->realJoin('INNER', $table, $firstTableCol, $operator,
                $secondTableCol);
    }

    /**
     * {@inheritDoc}
     */
    public function innerJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin('INNER', $table, $firstTableCol, $operator,
            $secondTableCol);
    }

    /**
     * {@inheritDoc}
     */
    public function outerJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'OUTER', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function leftJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'LEFT', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function leftOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'LEFT OUTER', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function rightJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'RIGHT', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function rightOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'RIGHT OUTER', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function fullOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'FULL OUTER', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * {@inheritDoc}
     */
    public function crossJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    ) {
        return $this->realJoin(
            'CROSS', $table, $firstTableCol, $operator, $secondTableCol
        );
    }

    /**
     * Build JOIN
     *
     * @return array
     * @access protected
     */
    protected function buildJoin()/*# : array */
    {
        $result = [];
        foreach ($this->clause_join as $join) {

            // join type, INNER JOIN etc.
            $res = [ $join[1] ];

            // raw mode
            if ($join[0]) {
                $res[] = $join[2];

            } else {
                // join table
                $tbl = $join[2];
                if (is_object($tbl) && $tbl instanceof SelectInterface) {
                    $res[] = '('. $tbl->getSql([], $this->getDialect(), false) .')';
                } else {
                    $res[] = $this->quote($tbl);
                }

                // table alias if any
                if ($join[4]) {
                    $tbl = $join[4];
                    $res[] = 'AS ' . $this->quote($tbl);
                }

                // on clause
                $res[] = $this->buildJoinOn($join[3], $tbl);
            }

            $result[] = join(' ', $res);
        }
        return $result;
    }

    /**
     * Build ON
     *
     * @param  string|array|object|null $input
     * @param  string $table joined table or table alias
     * @return string
     * @access protected
     */
    protected function buildJoinOn($input, $table)/*# : string */
    {
        // original table
        $tbl1 = $this->getTableName();

        if (is_array($input)) {
            $res = ['ON'];

            // first table
            if (false === strpos($input[0], '.')) {
                $res[] = $this->quote($tbl1 . '.' . $input[0]);
            } else {
                $res[] = $this->quote($input[0]);
            }

            // operator
            $res[] = $input[1];

            // second table
            if (false === strpos($input[2], '.')) {
                $res[] = $this->quote($table . '.' . $input[2]);
            } else {
                $res[] = $this->quote($input[2]);
            }
        } elseif (is_object($input)) {
            $res[] = $input->getSql([], $this->getDialect(), false);

        } elseif (is_string($input)) {
            $res = ['ON', $input];
        }

        return join(' ', $res);
    }

    /* for subqueries */
    abstract public function getDialect()/*# : DialectInterface */;

    /* utilities from UtilityTrait */
    abstract protected function isRaw(/*# string */ $string)/*# : bool */;
    abstract protected function quote(/*# string */ $str)/*# : string */;

    /* utilities from FromTrait */
    abstract protected function getTableName($returnAlias = false)/*# : string */;
    abstract protected function splitAlias(/*# string */ $string)/*# : array */;
}

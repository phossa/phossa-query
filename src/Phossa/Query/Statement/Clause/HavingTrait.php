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
 * HavingTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     HavingInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait HavingTrait
{
    /**
     * {@inheritDoc}
     */
    public function having(
        /*# string */ $col,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $value  = WhereInterface::NO_VALUE,
        /*# bool */ $logicAnd = true
    ) {
        return $this->where(
            $col, $operator, $value, $logicAnd, false, false, 'having'
        );
    }

    /**
     * {@inheritDoc}
     */
    public function orHaving(
        /*# string */ $col,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $value = WhereInterface::NO_VALUE
    ) {
        return $this->having($col, $operator, $value, false);
    }

    /**
     * {@inheritDoc}
     */
    public function havingRaw(/*# string */ $having)
    {
        return $this->having($having);
    }

    /**
     * {@inheritDoc}
     */
    public function orHavingRaw(/*# string */ $having)
    {
        return $this->having($having, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, false);
    }

    /**
     * Build HAVING
     *
     * @return array
     * @access protected
     */
    protected function buildHaving()/*# : array */
    {
        return $this->buildWhere('having');
    }

    abstract public function where(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false,
        /*# string */ $clause = 'where'
    );

    abstract protected function buildWhere(/*# string */ $clause = 'where');
}

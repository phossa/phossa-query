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
 * FunctionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait FunctionTrait
{
    /**
     * {@inheritDoc}
     */
    public function func(
        /*# string */ $function,
        /*# string */ $col,
        /*# string */ $alias = ''
    ) {
        $rawMode = $this->isRaw($col);
        if ('' === $alias) {
            $this->clause_column[] = [$rawMode, $col, $function];
        } else {
            $this->clause_column[(string) $alias] = [$rawMode, $col, $function];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function count(
        /*# string */ $col,
        /*# string */ $alias = ''
    ) {
        return $this->func('COUNT(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function min(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->func('MIN(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function max(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->func('MAX(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function avg(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->func('AVG(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function sum(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->func('SUM(%s)', $col, $alias);
    }

    /**
     * {@inheritDoc}
     */
    public function sumDistinct(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->func('SUM(DISTINCT %s)', $col, $alias);
    }

    /* utilities from UtilityTrait */
    abstract protected function isRaw(/*# string */ $string)/*# : bool */;
}

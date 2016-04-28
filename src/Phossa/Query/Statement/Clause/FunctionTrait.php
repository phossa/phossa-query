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
    public function count(
        /*# string */ $col,
        /*# string */ $alias = '',
        /*# string */ $function = 'COUNT(%s)'
    ) {
        // auto raw mode detection @todo
        $rawMode = false;

        if ('' === $alias) {
            $this->clauses['col'][] = [$rawMode, $col, $function];
        } else {
            $this->clauses[(string) $alias] = [$rawMode, $col, $function];
        }
        $this->clauses['col'][] = [$rawMode, $col, $function];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function min(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->count($col, $alias, 'MIN(%s)');
    }

    /**
     * {@inheritDoc}
     */
    public function max(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->count($col, $alias, 'MAX(%s)');
    }

    /**
     * {@inheritDoc}
     */
    public function avg(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->count($col, $alias, 'AVG(%s)');
    }

    /**
     * {@inheritDoc}
     */
    public function sum(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->count($col, $alias, 'SUM(%s)');
    }

    /**
     * {@inheritDoc}
     */
    public function sumDistinct(/*# string */ $col, /*# string */ $alias = '')
    {
        return $this->count($col, $alias, 'SUM(DISTINCT %s)');
    }
}

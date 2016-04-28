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
        /*# string */ $value = WhereInterface::NO_VALUE,
        /*# bool */ $rawMode = false
    ) {
        if ($rawMode) {
            $this->clauses['having'][] = [$rawMode, $col];
        } else {
            if (WhereInterface::NO_VALUE === $value) {
                $value = $operator;
                $operator = '=';
            }
            $this->clauses['having'][] = [$rawMode, $col, $operator, $value];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function havingRaw(/*# string */ $having)
    {
        return $this->having(
            $having,
            WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE,
            true
        );
    }
}

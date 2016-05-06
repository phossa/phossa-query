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

use Phossa\Query\Statement\Clause\WhereInterface;

/**
 * OnTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OnInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait OnTrait
{
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
        $this->clauses['on'][] = $on;

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

    /**
     * {@inheritDoc}
     */
    public function onRaw(/*# string */ $on)
    {
        return $this->on($on, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE);
    }

    /**
     * {@inheritDoc}
     */
    public function orOnRaw(/*# string */ $on)
    {
        return $this->on($on, WhereInterface::NO_OPERATOR,
            WhereInterface::NO_VALUE, true);
    }

    /**
     * Build ON
     *
     * @return array
     * @access protected
     */
    protected function buildOn()/*# : array */
    {
        $result = [];
        if (isset($this->clauses['on'])) {
            foreach ($this->clauses['on'] as $on) {
                $res = [ $on[0] ? 'OR ON' : 'ON'];
                $res[] = $this->quote($on[1]); // first col
                $res[] = $on[2]; // operator
                $res[] = $this->quote($on[3]); // second col
                $result[] = join(' ', $res);
            }
        }
        return $result;
    }

    abstract protected function quote(/*# string */ $str)/*# : string */;
}

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

namespace Phossa\Query\Clause;

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
     * ONs
     *
     * @var    array
     * @access protected
     */
    protected $clause_on = [];

    /**
     * {@inheritDoc}
     */
    public function on(
        /*# string */ $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE,
        /*# bool */ $or = false
    ) {
        if (ClauseInterface::NO_OPERATOR === $operator) {
            $on = [$or, $firstTableCol, '=', $firstTableCol];
        } elseif (ClauseInterface::NO_VALUE === $secondTableCol) {
            $on = [$or, $firstTableCol, '=', $operator];
        } else {
            $on = [$or, $firstTableCol, $operator, $secondTableCol];
        }
        $this->clause_on[] = $on;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function orOn(
        /*# string */ $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
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
        return $this->on($on, ClauseInterface::NO_OPERATOR,
            ClauseInterface::NO_VALUE);
    }

    /**
     * {@inheritDoc}
     */
    public function orOnRaw(/*# string */ $on)
    {
        return $this->on($on, ClauseInterface::NO_OPERATOR,
            ClauseInterface::NO_VALUE, true);
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
        foreach ($this->clause_on as $on) {
            $res = [ $on[0] ? 'OR' : 'ON'];
            $res[] = $this->quote($on[1]); // first col
            $res[] = $on[2]; // operator
            $res[] = $this->quote($on[3]); // second col
            $result[] = join(' ', $res);
        }
        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

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

use Phossa\Query\Message\Message;
use Phossa\Query\Exception\InvalidArgumentException;

/**
 * BeforeAfterTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     BeforeAfterInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait BeforeAfterTrait
{
    /**
     * before clause pool
     *
     * @var    array
     * @access protected
     */
    protected $before = [];

    /**
     * after clause pool
     *
     * @var    array
     * @access protected
     */
    protected $after  = [];

    /**
     * {@inheritDoc}
     */
    public function before(
        /*# string */ $position,
        /*# string */ $clause
    ) {
        $pos = $this->getPosition($position);
        $this->before[$pos][] = $clause;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function after(
        /*# string */ $position,
        /*# string */ $clause
    ) {
        $pos = $this->getPosition($position);
        $this->after[$pos][] = $clause;
        return $this;
    }

    /**
     * @param  string $position
     * @return int
     * @throws InvalidArgumentException if position unknown
     * @access protected
     */
    protected function getPosition(/*# string */ $position)/*# : int */
    {
        $c = get_class($this) . '::' . 'ORDER_' . strtoupper($position);
        if (!defined($c)) {
            throw new InvalidArgumentException(
                Message::get(Message::SQL_UNKNOWN_POS, $position),
                Message::SQL_UNKNOWN_POS
            );
        }
        return constant($c);
    }
}

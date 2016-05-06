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

namespace Phossa\Query\Statement;

/**
 * PreviousTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     PreviousInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait PreviousTrait
{
    /**
     * Previous statement
     *
     * @var    StatementInterface
     * @access protected
     */
    protected $previous;

    /**
     * {@inheritDoc}
     */
    public function setPrevious(StatementInterface $previous)
    {
        $this->previous = $previous;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPrevious()/*# : bool */
    {
        return null !== $this->previous;
    }

    /**
     * {@inheritDoc}
     */
    public function getPrevious()/*# : StatementInterface */
    {
        return $this->previous;
    }
}

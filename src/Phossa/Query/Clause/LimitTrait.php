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
 * LimitTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     LimitInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait LimitTrait
{
    /**
     * LIMIT
     *
     * @var    array
     * @access protected
     */
    protected $clause_limit = [];

    /**
     * {@inheritDoc}
     */
    public function limit(/*# int */ $count, /*# int */ $offset = 0)
    {
        if ($count || $offset) {
            if (!empty($this->clause_limit)) {
                $this->clause_limit[0] = (int) $count;
            } else {
                $this->clause_limit = [(int) $count, (int) $offset];
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offset(/*# int */ $offset)
    {
        if (!empty($this->clause_limit)) {
            $this->clause_limit[1] = (int) $offset;
        } else {
            $this->clause_limit = [ 0, (int) $offset];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30)
    {
        $this->clause_limit = [(int) $perPage, ($pageNumber - 1) * $perPage];
        return $this;
    }

    /**
     * Build LIMIT
     *
     * @return array
     * @access protected
     */
    protected function buildLimit()/*# : array */
    {
        $result = [];
        if (!empty($this->clause_limit)) {
            $res = [];

            if ($this->clause_limit[0]) {
                $res[] = 'LIMIT ' . $this->clause_limit[0];
            }

            if ($this->clause_limit[1]) {
                $res[] = 'OFFSET ' . $this->clause_limit[1];
            }

            if (!empty($res)) {
                $result[] = join(' ', $res);
            }
        }
        return $result;
    }
}

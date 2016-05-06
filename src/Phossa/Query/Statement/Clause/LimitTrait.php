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
     * {@inheritDoc}
     */
    public function limit(/*# int */ $count, /*# int */ $offset = 0)
    {
        if ($count || $offset) {
            if (isset($this->clauses['limit'])) {
                $this->clauses['limit'][0] = (int) $count;
            } else {
                $this->clauses['limit'] = [(int) $count, (int) $offset];
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offset(/*# int */ $offset)
    {
        if (isset($this->clauses['limit'])) {
            $this->clauses['limit'][1] = (int) $offset;
        } else {
            $this->clauses['limit'] = [ 0, (int) $offset];
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30)
    {
        $this->clauses['limit'] = [(int) $perPage, ($pageNumber - 1) * $perPage];
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
        if (isset($this->clauses['limit'])) {
            $res = [];

            if ($this->clauses['limit'][0]) {
                $res[] = 'LIMIT ' . $this->clauses['limit'][0];
            }

            if ($this->clauses['limit'][1]) {
                $res[] = 'OFFSET ' . $this->clauses['limit'][1];
            }

            if (!empty($res)) {
                $result[] = join(' ', $res);
            }
        }
        return $result;
    }
}

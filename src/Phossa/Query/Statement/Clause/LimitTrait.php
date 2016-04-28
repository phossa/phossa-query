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
        $this->clauses['limit'] = [$count, $offset];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function offset(/*# int */ $offset)
    {
        $this->clauses['offset'] = $offset;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function page(/*# int */ $pageNumber, /*# int */ $perPage = 30)
    {
        $this->clauses['limit'] = [$perPage, ($pageNumber - 1) * $perPage];
        return $this;
    }
}

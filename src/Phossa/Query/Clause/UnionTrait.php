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

use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\Common\SelectStatementInterface;

/**
 * UnionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UnionInterface
 * @see     SelectStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait UnionTrait
{
    /**
     * UNIONs
     *
     * @var    array
     * @access protected
     */
    protected $clause_union = [];

    /**
     * {@inheritDoc}
     */
    public function union()/*# : BuilderInterace */
    {
        $this->clause_union[] = 'UNION';
        return $this->getBuilder()->setPrevious($this);
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : BuilderInterace */
    {
        $this->clause_union[] = 'UNION ALL';
        return $this->getBuilder()->setPrevious($this);
    }

    /**
     * Build UNION/UNION ALL
     *
     * @return array
     * @access protected
     */
    protected function buildUnion()/*# : array */
    {
        $result = [];
        foreach ($this->clause_union as $union) {
            $result[] = $union;
        }
        return $result;
    }

    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    abstract public function getBuilder()/*# : BuilderInterface */;
}

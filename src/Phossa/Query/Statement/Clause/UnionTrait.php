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

use Phossa\Query\Statement\Select;
use Phossa\Query\Statement\SelectInterface;

/**
 * UnionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UnionInterface
 * @see     SelectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait UnionTrait
{
    /**
     * {@inheritDoc}
     */
    public function union()/*# : SelectInterace */
    {
        $this->clauses['union'][] = 'UNION';
        return (new Select($this->getBuilder()))->setPrevious($this);
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : SelectInterace */
    {
        $this->clauses['union'][] = 'UNION ALL';
        return (new Select($this->getBuilder()))->setPrevious($this);
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
        if (isset($this->clauses['union'])) {
            foreach ($this->clauses['union'] as $union) {
                $result[] = $union;
            }
        }
        return $result;
    }

    abstract public function getBuilder()/*# : BuilderInterface */;
}

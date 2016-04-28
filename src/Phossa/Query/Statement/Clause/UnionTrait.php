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

use Phossa\Query\Statement\SelectInterface;

/**
 * UnionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UnionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait UnionTrait
{
    /**
     * {@inheritDoc}
     */
    public function union(
        SelectInterface $select,
        /*# bool */ $unionAll = false
    ) {
        $this->clauses['union'] = [$unionAll, $select];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll(SelectInterface $select)
    {
        return $this->union($select, true);
    }
}

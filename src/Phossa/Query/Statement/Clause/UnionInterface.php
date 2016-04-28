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
 * UnionInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface UnionInterface
{
    /**
     * Union with another SELECT
     *
     * @param  SelectInterface $select
     * @param  bool $unionAll
     * @return $this;
     * @access public
     */
    public function union(
        SelectInterface $select,
        /*# bool */ $unionAll = false
    );

    /**
     * Union all with another SELECT
     *
     * @param  SelectInterface $select
     * @return $this;
     * @access public
     */
    public function unionAll(SelectInterface $select);
}

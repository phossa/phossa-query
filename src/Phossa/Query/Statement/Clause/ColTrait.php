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
 * ColTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ColInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ColTrait
{
    /**
     * {@inheritDoc}
     */
    public function distinct()
    {
        $this->clauses['distinct'] = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function col(
        $col,
        /*# string */ $colAlias = '',
        $rawMode = false
    ) {
        if (is_array($col)) {
            foreach ($col as $key => $val) {
                if (is_int($key)) {
                    $this->clauses['col'][] = [$rawMode, $val];
                } else {
                    $this->clauses['col'][$val] = [$rawMode, $key];
                }
            }
        } else {
            if ('' === $colAlias) {
                $this->clauses['col'][] = [$rawMode, $col];
            } else {
                $this->clauses[(string) $colAlias] = [$rawMode, $col];
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function colRaw($string, /*# string */ $alias = '')
    {
        return $this->col($string, $alias, true);
    }
}

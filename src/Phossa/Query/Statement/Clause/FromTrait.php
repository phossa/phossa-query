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
 * FromTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     FromInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait FromTrait
{
    /**
     * {@inheritDoc}
     */
    public function from(
        $table,
        /*# string */ $tableAlias = ''
    )/* : FromInterface */ {
        if (is_array($table)) {
            $this->clauses['from'] = $table;
        } else {
            if (empty($tableAlias)) {
                $this->clauses['from'][] = $table;
            } else {
                $this->clauses['from'][(string) $tableAlias] = $table;
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function table(
        $table,
        /*# string */ $tableAlias = ''
    )/* : FromInterface */ {
        return $this->from($table, $tableAlias);
    }
}

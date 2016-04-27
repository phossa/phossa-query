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
    public function from($table, /*# string */ $tableAlias = '')
    {
        if (is_array($table)) {
            $this->clauses['from'] = $table;
        } else {
            if (empty($tableAlias)) {
                $this->clauses['from'][] = (string) $table;
            } else {
                $this->clauses['from'][(string) $table] = (string) $tableAlias;
            }
        }
        return $this;
    }
}

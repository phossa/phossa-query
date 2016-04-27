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

namespace Phossa\Query;

use Phossa\Query\Statement\SelectInterface;
use Phossa\Query\Dialect\DialectAwareInterface;
use Phossa\Query\Statement\Clause\FromInterface;

/**
 * BuilderInterface
 *
 * Build statements and manage dialect and global settings for them
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @see     DialectAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsInterface
{
    /**
     * Set tables
     *
     * ```php
     * // a user table query builder
     * $user = $builder->table('MyUserTable', 'u');
     *
     * // working on user table
     * $user->select()->...
     * ```
     *
     * @param  string|array $table(s) table to use
     * @param  string $tableAlias alias to be used later in the query
     * @return $this
     * @see    FromInterface
     * @access public
     */
    public function table($table, /*# string */ $tableAlias = '');

    /**
     * Build a SELECT statement
     *
     * Add field[s] to SELECT query
     *
     * ```php
     *     // SELECT DISTINCT
     *     ->select()->distinct()
     *
     *     // SELECT `user_name`
     *     ->select('user_name')
     *
     *     // SELECT `user_name` AS `n`
     *     ->select('user_name', 'n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select(['user_id', 'user_name'])
     *
     *     // SELECT `user_id`, `user_name` AS `n`
     *     ->select(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  string|array $field field specification[s]
     * @param  string $fieldAlias alias name for $field
     * @return SelectInterface
     * @access public
     */
    public function select(
        $field,
        /*# string */ $fieldAlias = ''
    )/*# : SelectInterface */;
}

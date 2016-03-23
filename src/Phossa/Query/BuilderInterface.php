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

/**
 * BuilderInterface
 *
 * Build statements and manage dialect and global settings for them
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @see     Dialect\DialectAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderInterface extends Dialect\DialectAwareInterface, SettingsInterface
{
    /**
     * Set tables
     *
     * @param  string|array $tables table to use
     * @return static
     * @access public
     * @api
     */
    public function table($tables);

    /**
     * Build SELECT statement
     *
     * Add field[s] to SELECT query
     *
     * ```php
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
     * @param  string|array $field field specification
     * @param  string $as field alias name
     * @return Statement\SelectInterface
     * @access public
     * @api
     */
    public function select(
        $field,
        /*# string */ $as = ''
    )/*# : Statement\SelectInterface */;
}

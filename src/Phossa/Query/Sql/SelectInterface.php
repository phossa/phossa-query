<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql;

use Phossa\Query\Dialect;
use Phossa\Query\Exception;

/**
 * Select related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SelectInterface
{
    /**
     * From table[s]
     *
     * If no arguments provided, reset FROM
     *
     * <code>
     *     // FROM `users`
     *     ->from('users')
     *
     *     // FROM `users` `u`
     *     ->from('users', 'u')
     *
     *     // FROM `users`, `accounts`
     *     ->from(['users', 'accounts'])
     *
     *     // FROM `users`, `accounts` `a`
     *     ->from(['users', 'accounts' => 'a'])
     * </code>
     *
     * @param  string|string[]|object (optional) $table table specification[s]
     * @param  string $as (optional) table alias name
     * @return this
     * @access public
     * @api
     */
    public function from(
        $table = '',
        /*# string */ $as = ''
    )/*# : SelectInterface */;

    /**
     * Add field[s] to query
     *
     * If no arguments provided, reset fields
     *
     * <code>
     *     // SELECT `user_name`
     *     ->field('user_name')
     *
     *     // SELECT `user_name` AS `n`
     *     ->field('user_name', 'n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->field(['user_id', 'user_name'])
     *
     *     // SELECT `user_id`, `user_name` AS `n`
     *     ->field(['user_id', 'user_name' => 'n'])
     * </code>
     *
     * @param  string|string[]|object (optional) $field field specification
     * @param  string $as (optional) field alias name
     * @return this
     * @access public
     * @api
     */
    public function field(
        $field = '',
        /*# string */ $as = ''
    )/*# : SelectInterface */;

    /**
     * Set DISTINCT
     *
     * @param  void
     * @return this
     * @access public
     * @api
     */
    public function distinct()/*# : SelectInterface */;

    /**
     * Select into new table (or alias)
     *
     * <code>
     *     // SELECT * INTO `users` FROM `old_users`
     *     ->select()->from('old_users')->into('users')
     * </code>
     *
     * @param  string $tblSpec table specification
     * @return this
     * @access public
     * @api
     */
    public function into(
        /*# string */ $tblSpec
    )/*# : SelectInterface */;

    /**
     * Union selects
     *
     * <code>
     *     // start a new query
     *     ->select()->from('users').whereNull('phone')
     *     ->union()
     *     ->select()->from('users').whereNull('address')
     *
     *     // callable
     *     ->select()->from('users').whereNull('phone')
     *     ->union(functio($q) {
     *         $q->select()->from('users').whereNull('address')
     *     })
     * </code>
     *
     * @param  variable parameters
     * @return this
     * @access public
     * @api
     */
    public function union()/*# : SelectInterface */;

    /**
     * UNION ALL selects
     *
     * @param  callable $query callable return a SelectQueryInterface
     * @return this
     * @see    self::union()
     * @access public
     * @api
     */
    public function unionAll()/*# : SelectInterface */;
}

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
     * @param  string|string[] $table table specification[s]
     * @param  string $as (optional) table alias name
     * @return this
     * @throws Exception\InvalidArgumentException
     * @access public
     * @api
     */
    public function from(
        $table,
        /*# string */ $as = ''
    )/*# : SelectQueryInterface */;

    /**
     * Add field[s] to query
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
     * @param  string|string[] $field field specification
     * @param  string $as (optional) field alias name
     * @return this
     * @throws Exception\InvalidArgumentException
     * @access public
     * @api
     */
    public function field(
        $field,
        /*# string */ $as = ''
    )/*# : SelectQueryInterface */;

    /**
     * Set DISTINCT
     *
     * @param  void
     * @return this
     * @access public
     * @api
     */
    public function distinct()/*# : SelectQueryInterface */;

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
    )/*# : SelectQueryInterface */;

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
    public function union()/*# : SelectQueryInterface */;

    /**
     * UNION ALL selects
     *
     * @param  callable $query callable return a SelectQueryInterface
     * @return this
     * @see    self::union()
     * @access public
     * @api
     */
    public function unionAll()/*# : SelectQueryInterface */;

    /**
     * Insert strings BEFORE specific query position
     *
     * <code>
     *     // SELECT * INTO users FROM old_users
     *     select()->before('from', 'INTO users')->from('old_users')
     * </code>
     *
     * @param  string $location location in the query
     * @param  string $string string to insert
     * @return this
     * @access public
     * @api
     */
    public function before(
        /*# : string */ $location,
        /*# : string */ $string
    )/*# : SelectQueryInterface */;

    /**
     * Insert strings AFTER specific query position
     *
     * <code>
     *     // SELECT * FROM old_users PARTITION `x` WHERE user_id > 100
     *     select()
     *       ->from('old_users')
     *       ->after('from', 'PARTITION x')
     *       ->where('user_id', '>', 100)
     * </code>
     *
     * @param  string $location location in the query
     * @param  string $string string to insert
     * @return this
     * @access public
     * @api
     */
    public function after(
        /*# : string */ $location,
        /*# : string */ $string
    )/*# : SelectQueryInterface */;

    /**
     * Query related options
     *
     * @param  string|array $options query related options
     * @return this
     * @throws void
     * @access public
     * @api
     */
    public function options(
        $options
    )/*# : SelectQueryInterface */;
}

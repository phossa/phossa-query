<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql\Select;

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
     * Select clause
     *
     * <code>
     *     // MODE_STRICT: SELECT *
     *     ->select()
     *
     *     // MODE_STRICT: SELECT `user_id`
     *     ->select('user_id')
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name`
     *     ->select('user_id', 'user_name')
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name`
     *     ->select(['user_id', 'user_name'])
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name` AS `n`
     *     ->select(['user_id', 'user_name' => 'n'])
     *
     *     // SELECT `user_id` AS `i`
     *     ->select('user_id AS i')
     *
     *     // SELECT `user_id` AS `i`, `user_name` AS `n`
     *     ->select('user_id AS i', 'user_name AS n')
     *
     *     // SELECT `user_id` AS `u`, `user_name` AS `n`
     *     ->select(['user_id AS i', 'user_name AS n'])
     * </code>
     *
     * @param  string|array variable parameters
     * @return this
     * @access public
     * @api
     */
    public function select()/*# : SelectQueryInterface */;

    /**
     * From clause
     *
     * <code>
     *     // MODE_STRICT: FROM `users`
     *     ->from('users')
     *
     *     // MODE_STRICT: FROM `users`, `accounts`
     *     ->from('users', 'accounts')
     *
     *     // MODE_STRICT: FROM `users`, `accounts`
     *     ->from(['users', 'accounts'])
     *
     *     // MODE_STRICT: FROM `users`, 'accounts' AS `a`
     *     ->from(['users', 'accounts' => 'a'])
     *
     *     // FROM `users` AS `u`
     *     ->from('users as u')
     *
     *     // FROM `users` AS `u`, `accounts` AS `a`
     *     ->from('users as u', 'accounts as a')
     *
     *     // FROM `users` AS `u`, `accounts` AS `a`
     *     ->from(['users AS u', 'accounts AS a'])
     * </code>
     *
     * @param  string|array $tblSpec table specifications
     * @return this
     * @access public
     * @api
     */
    public function from(
        $tblSpec
    )/*# : SelectQueryInterface */;

    /**
     * From clause with second argument is the alias(es)
     *
     * First argument may be a subselect
     *
     * <code>
     *     // MODE_STRICT: FROM `users` AS `u`, `accounts` AS `a`
     *     ->fromAs('users', 'u')->fromAs('accounts', 'a')
     *
     *     // MODE_STRICT: FROM `users` AS `u`, `accounts` AS `a`
     *     ->fromAs(['users', 'accounts'], ['u', 'a'])
     * </code>
     *
     * @param  string|array $table table specification or subselect
     * @param  string|array $as alias name
     * @return this
     * @access public
     * @api
     */
    public function fromAs(
        $table,
        $as
    )/*# : SelectQueryInterface */;

    /**
     * Select column[s] to query, usage is same as self::select()
     *
     * <code>
     *     // MODE_STRICT: SELECT `user_name`
     *     ->column('user_name')
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name`
     *     ->column('user_id', 'user_name')
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name`
     *     ->column(['user_id', 'user_name'])
     *
     *     // MODE_STRICT: SELECT `user_id`, `user_name` AS `n`
     *     ->column(['user_id', 'user_name' => 'n'])
     *
     *     // SELECT `user_name` AS `n`
     *     ->column('user_name AS n')
     *
     *     // SELECT `user_id` AS `i`, `user_name` AS `n`
     *     ->column('user_id AS i', 'user_name AS n')
     *
     *     // SELECT `user_id` AS `i`, `user_name` AS `n`
     *     ->column(['user_id AS i', 'user_name AS n'])
     * </code>
     *
     * @param  string|array $colSpec column specification
     * @param  string variable parameters
     * @return this
     * @see    self::select()
     * @access public
     * @api
     */
    public function column(
        $colSpec
    )/*# : SelectQueryInterface */;

    /**
     * Select column[s] with second argument as its alias(es)
     *
     * <code>
     *     // MODE_STRICT: SELECT COUNT(`user_name`) AS `cnt`
     *     ->columnAs('COUNT(user_name)', 'cnt')
     *
     *     // MODE_STRICT: SELECT `user_id` AS `id`, `user_name` AS `name`
     *     ->columnAs(['user_id', 'user_name'], ['id', 'name'])
     * </code>
     *
     * @param  string|array $colSpec column specification
     * @param  string|array $as alias name
     * @return this
     * @access public
     * @api
     */
    public function columnAs(
        $colSpec,
        $as
    )/*# : SelectQueryInterface */;

    /**
     * Select distinct column, usage is same as self::column()
     *
     * <code>
     *     // MODE_STRICT: SELECT DISTINCT `gender`, `age`
     *     select()->distinct('gender', 'age')
     *
     *     // SELECT DISTINCT `gender` AS `g`, `age`
     *     select('gender AS g', 'age')->distinct()
     * </code>
     *
     * @param  string variable parameters
     * @return this
     * @see    self::column()
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

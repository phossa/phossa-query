<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Select;

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
     *     // SELECT *
     *     ->select()
     *
     *     // SELECT `user_id`, `user_name`
     *     ->setColPrefix('user_')->select('id', 'name')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select('user_id', 'user_name')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select(['user_id', 'user_name'])
     *
     *     // SELECT `user_id` AS `u`, `user_name` AS `n`
     *     ->select(['user_id' => 'u', 'user_name' => 'n'])
     * </code>
     *
     * @param  string|array variable parameters
     * @return this
     * @access public
     * @api
     */
    public function select()/*# : SelectQueryInterface */;

    /**
     * Wrap whole select with an AS
     *
     * Use columns() to specify columns to select
     *
     * <code>
     *     // (SELECT * ..) AS `x`
     *     ->selectAs('x')
     *
     *     // (SELECT `user_name` FROM `users`) AS `x`
     *     ->selectAs('x')->col('user_name')->from('users')
     * </code>
     *
     * @param  string $as alias name
     * @return this
     * @access public
     * @api
     */
    public function selectAs(
        /*# string */ $as
    )/*# : SelectQueryInterface */;

    /**
     * From clause
     *
     * <code>
     *     // FROM `users`
     *     ->from('users')
     *
     *     // FROM `users` AS `u`
     *     ->from('users as u')
     *
     *     // FROM `users`, `accounts`
     *     ->from(['users', 'accounts'])
     *
     *     // FROM `users` AS `u`, `accounts` AS `a`
     *     ->from('users as u', 'accounts as a')
     *
     *     // FROM `users` AS `u`, 'accounts' AS `a`
     *     ->from(['users' => 'u', 'accounts' => 'a'])
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
     * From clause with table alias
     *
     * <code>
     *     // FROM `users` AS `u`, `accounts` AS `a`
     *     ->fromAs('users', 'u')
     *     ->fromAs('accounts', 'a')
     *
     *     // same as above
     *     ->fromAs(['users', 'accounts'], ['u', 'a'])
     * </code>
     *
     * @param  string|array $table table specification
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
     * Add columns to query, usage is same as self::select()
     *
     * <code>
     *     // SELECT `user_name`
     *     ->column('user_name')
     *
     *     // SELECT `user_name` AS `n`
     *     ->column('user_name AS n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->column('user_id', 'user_name')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->column(['user_id', 'user_name'])
     *
     *     // SELECT `user_id` AS id, `user_name` AS name
     *     ->column(['user_id' => 'id', 'user_name' => 'name'])
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
     * Add column (with its alias) to query
     *
     * <code>
     *     // SELECT COUNT(`user_name`) AS `cnt`
     *     ->columnAs('COUNT(user_name)', 'cnt')
     *
     *     // SELECT `user_id` AS `id`, `user_name` AS `name`
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
     *     // SELECT DISTINCT `gender`, `age`
     *     select()->distinct('gender', 'age')
     *
     *     // SELECT DISTINCT `gender`, `age`
     *     select('gender', 'age')->distinct()
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
     * Select into new table
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

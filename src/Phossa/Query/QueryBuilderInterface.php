<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * QueryBuilder interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryBuilderInterface extends QueryInterface
{
    /**
     * Select query
     *
     * <code>
     *     // SELECT *
     *     ->select()
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select('user_id', 'user_name')
     *
     *     // SELECT `user_id` AS `u`, `user_name` AS `n`
     *     ->select('user_id as u', 'user_name as n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select(['user_id', 'user_name'])
     *
     *     // SELECT `user_id` AS `u`, `user_name` AS `n`
     *     ->select(['user_id' => 'u', 'user_name' => 'n'])
     * </code>
     *
     * @param  string|array variable parameters
     * @return Select\SelectQueryInterface
     * @access public
     * @api
     */
    public function select()/*# : Select\SelectQueryInterface */;
}

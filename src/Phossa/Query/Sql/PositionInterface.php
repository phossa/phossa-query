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

/**
 * Insert into different position
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface PositionInterface
{
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
    )/*# : PositionInterface */;

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
    )/*# : PositionInterface */;
}

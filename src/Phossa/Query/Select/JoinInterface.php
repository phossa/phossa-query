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
 * Join related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface JoinInterface
{
    /**
     * Inner join the table
     *
     * <code>
     *     // simplest mode, if table structure known, same columns matched
     *     // INNER JOIN `users` ON sale.usr_id = users.usr_id
     *     ->join('users')
     *
     *     // mode: join('table', 'column')
     *     // result: INNER JOIN `users` ON `sale`.`usr_id` = `users`.`usr_id`
     *     ->join('users', 'usr_id')
     *
     *     // mode: join('table', 'condition')
     *     // result: INNER JOIN `users` ON sale.usr_id = users.usr_id
     *     ->join('users', 'sale.usr_id = users.usr_id')
     *
     *     // mode: join('table', 'column1', 'column2')
     *     // result: INNER JOIN `users` ON `sale`.`sale_usr` = `users`.`usr_id`
     *     ->join('users', 'sale_usr', 'usr_id')
     *
     *     // mode: join('table', 'column1', 'column2', 'operator')
     *     // result: INNER JOIN `users` ON `sale`.`sale_usr` = `users`.`usr_id`
     *     ->join('users', 'sale_usr', 'usr_id', '=')
     *
     *     // mode: follow by 'andOn' or 'orOn'
     *     ->join('users', 'sale_usr', 'usr_id')->orOn('accnt_id', 'usr_id')
     *
     * </code>
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @access public
     * @api
     */
    public function join(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Alias of self::join()
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function innerJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Left join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function leftJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Left outer join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function leftOuterJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Right join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function rightJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Right outer join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function rightOuterJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Outer join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function outerJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Cross join the table
     *
     * @param  string $table table specification
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::join()
     * @access public
     * @api
     */
    public function crossJoin(
        /*# string */ $table
    )/*# : SelectQueryInterface */;

    /**
     * Extra and on clause
     *
     * @param  string $column1 column name
     * @param  mixed ... variable parameters
     * @return this
     * @access public
     * @api
     */
    public function andOn(
        /*# string */ $column1
    )/*# : SelectQueryInterface */;

    /**
     * Extra and or on clause
     *
     * @param  string $column1 column name
     * @param  mixed ... variable parameters
     * @return this
     * @see    self::andOn()
     * @access public
     * @api
     */
    public function orOn(
        /*# string */ $column1
    )/*# : SelectQueryInterface */;
}

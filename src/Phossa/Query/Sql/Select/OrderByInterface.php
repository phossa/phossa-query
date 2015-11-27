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
 * Order by clause related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OrderByInterface
{
    /**
     * Order by
     *
     * <code>
     *     // ORDER BY `user_id` DESC
     *     ->orderBy('user_id DESC')
     *
     *     // ORDER BY `user_id` ASC (default to ASC)
     *     ->orderBy('user_id')
     *
     *     // ORDER BY `user_age` ASC, `user_score` ASC
     *     ->orderBy('user_age', 'user_score');
     *
     *     // ORDER BY `user_age` ASC, `user_score` ASC
     *     ->orderBy(['user_age', 'user_score']);
     *
     *     // ORDER BY `user_age` ASC, `user_score` DESC
     *     ->orderBy(['user_age' => 'asc', 'user_score' => 'desc');
     * </code>
     *
     * @param  string|array $order order by clause
     * @return this
     * @access public
     * @api
     */
    public function orderBy(
        $order
    )/*# : SelectQueryInterface */;

    /**
     * Order by ASC
     *
     * <code>
     *     // ORDER BY `user_id` ASC
     *     ->orderAscBy('user_id')
     *
     *     // ORDER BY `user_age` ASC, `user_score` ASC
     *     ->orderAscBy('user_age', 'user_score')
     *
     *     // ORDER BY `user_age` ASC, `user_score` ASC
     *     ->orderAscBy(['user_age', 'user_score']);
     * </code>
     *
     * @param  string|array $order order by clause
     * @return this
     * @see    self::orderBy()
     * @access public
     * @api
     */
    public function orderAscBy(
        $order
    )/*# : SelectQueryInterface */;

    /**
     * Order by DESC
     *
     * <code>
     *     // ORDER BY `user_id` DESC
     *     ->orderDescBy('user_id')
     *
     *     // ORDER BY `user_age` DESC, `user_score` DESC
     *     ->orderDescBy('user_age', 'user_score');
     *
     *     // ORDER BY `user_age` DESC, `user_score` DESC
     *     ->orderDescBy(['user_age', 'user_score']);
     * </code>
     *
     * @param  mixed $order order by clause
     * @return this
     * @see    self::orderBy()
     * @access public
     * @api
     */
    public function orderDescBy(
        $order
    )/*# : SelectQueryInterface */;
}

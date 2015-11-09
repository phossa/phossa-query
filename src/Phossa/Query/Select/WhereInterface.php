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
 * Where clause related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface WhereInterface
{
    /**
     * Generic WHERE clause with 'AND' logic
     *
     * e.g.
     * <code>
     *   // raw mode, WHERE age > 18
     *   ->where('age > 18')
     *
     *   // field/value mode, WHERE age = 18
     *   ->where('age', 18)
     *
     *   // operator mode, WHERE age > 18
     *   ->where('age', '>', 18)
     *
     *   // operator 'in', WHERE age IN (10,11,12)
     *   ->where('age', 'in', [10, 11, 12])
     *
     *   // operator 'between', WHERE age BETWEEN 10 AND 20
     *   ->where('age', 'between', 10, 20)
     *
     *   // object mode {'age' => 18, ...}, WHERE age = 18 AND gender = 'male'
     *   ->where($user)
     *
     *   // mixed mode, WHERE age > 18 AND gender = 'male'
     *   ->where('age > 18', ['gender', 'male'])
     *
     *   // array mode, WHERE age > 18 AND gender = 'male'
     *   ->where(['age', '>', 18], ['gender', 'male'])
     *
     *   // associate array mode, WHERE age = 18 AND gender = 'male'
     *   ->where(['age' => 18, 'gender' => 'male'])
     *
     *   // associate array mode, WHERE age > 18 AND score <= 100
     *   ->where(['age' => 18, 'score' => ['<=', 100]])
     *
     *   // callback mode, grouped where, WHERE (age = 18 OR score > 70)
     *   ->where(function($b) {
     *         $b->where('age', 18)
     *           ->orWhere('score', '>', 70);
     *     })
     *
     *   // subquery mode
     *   ->where('age', 'in', $subquery)
     * </code>
     *
     * @param  mixed variable parameters
     * @return this
     * @access public
     * @api
     */
    public function where()/*# : SelectQueryInterface */;

    /**
     * Generic WHERE clause with 'OR' logic
     *
     * @param  mixed variable parameters
     * @return this
     * @see    self::where()
     * @access public
     * @api
     */
    public function orWhere()/*# : SelectQueryInterface */;

    /**
     * Generic WHERE NOT ... AND NOT clause with 'AND' logic
     *
     * e.g.
     * <code>
     *   // WHERE NOT age > 18
     *   ->whereNot('age > 18')
     * </code>
     *
     * @param  mixed variable parameters
     * @return this
     * @see    self::where()
     * @access public
     * @api
     */
    public function whereNot()/*# : SelectQueryInterface */;

    /**
     * Generic WHERE NOT ... OR NOT clause
     *
     * @param  mixed variable parameters
     * @return this
     * @see    self::whereNot()
     * @access public
     * @api
     */
    public function orWhereNot()/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IN ...
     *
     * e.g.
     * <code>
     *   // WHERE age IN (10,11,12)
     *   ->whereIn('age', [10,11,12])
     *
     *   // WHERE age IN (select ...)
     *   ->whereIn('age', $subquery)
     *
     * </code>
     *
     * @param  string $column column name
     * @param  array|callable|SelectQueryInterface $cond
     * @return this
     * @access public
     * @api
     */
    public function whereIn(
        /*# string */ $column,
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IN ... with 'OR' logic
     *
     * @param  string $column column name
     * @param  array|callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereIn()
     * @access public
     * @api
     */
    public function orWhereIn(
        /*# string */ $column,
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column NOT IN ...
     *
     * @param  string $column column name
     * @param  array|callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereIn()
     * @access public
     * @api
     */
    public function whereNotIn(
        /*# string */ $column,
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column NOT IN ... with 'OR' logic
     *
     * @param  string $column column name
     * @param  array|callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereNotIn()
     * @access public
     * @api
     */
    public function orWhereNotIn(
        /*# string */ $column,
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column BETWEEN ...
     *
     * e.g.
     * <code>
     *   // WHERE age BETWEEN 10 AND 20
     *   ->whereBetween('age', [10, 20])
     * </code>
     *
     * @param  string $column column name
     * @param  array $range
     * @return this
     * @access public
     * @api
     */
    public function whereBetween(
        /*# string */ $column,
        array $range
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column BETWEEN ... with 'OR' logic
     *
     * @param  string $column column name
     * @param  array $range
     * @return this
     * @see    self::whereBetween()
     * @access public
     * @api
     */
    public function orWhereBetween(
        /*# string */ $column,
        array $range
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column NOT BETWEEN ...
     *
     * @param  string $column column name
     * @param  array $range
     * @return this
     * @see    self::whereBetween()
     * @access public
     * @api
     */
    public function whereNotBetween(
        /*# string */ $column,
        array $range
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column NOT BETWEEN ... with 'OR' logic
     *
     * @param  string $column column name
     * @param  array $range
     * @return this
     * @see    self::whereNotBetween()
     * @access public
     * @api
     */
    public function orWhereNotBetween(
        /*# string */ $column,
        array $range
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE EXISTS ...
     *
     * @param  callable|SelectQueryInterface $cond
     * @return this
     * @access public
     * @api
     */
    public function whereExists(
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE EXISTS with 'OR' logic
     *
     * @param  callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereExists()
     * @access public
     * @api
     */
    public function orWhereExists(
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE NOT EXISTS
     *
     * @param  callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereExists()
     * @access public
     * @api
     */
    public function whereNotExists(
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE NOT EXISTS with 'OR' logic
     *
     * @param  callable|SelectQueryInterface $cond
     * @return this
     * @see    self::whereNotExists()
     * @access public
     * @api
     */
    public function orWhereNotExists(
        $cond
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IS NULL
     *
     * e.g.
     * <code>
     *   // WHERE age IS NULL
     *   ->whereNull('age')
     * </code>
     *
     * @param  string $column column name
     * @return this
     * @access public
     * @api
     */
    public function whereNull(
        /*# string */ $column
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IS NULL with 'OR' logic
     *
     * @param  string $column column name
     * @return this
     * @see    self::whereNull()
     * @access public
     * @api
     */
    public function orWhereNull(
        /*# string */ $column
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IS NOT NULL
     *
     * e.g.
     * <code>
     *   // WHERE age IS NOT NULL
     *   ->whereNotNull('age')
     * </code>
     *
     * @param  string $column column name
     * @return this
     * @see    self::whereNull()
     * @access public
     * @api
     */
    public function whereNotNull(
        /*# string */ $column
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE column IS NOT NULL with 'OR' logic
     *
     * @param  string $column column name
     * @return this
     * @see    self::whereNotNull()
     * @access public
     * @api
     */
    public function orWhereNotNull(
        /*# string */ $column
    )/*# : SelectQueryInterface */;

    /**
     * Generic WHERE clause with 'AND' logic
     *
     * e.g.
     * <code>
     *   // raw mode, WHERE age > 18
     *   ->whereRaw('age > 18')
     *   ->whereRaw('gender = ?', ['male'])
     * </code>
     *
     * @param  string $clause raw where clause with placeholders
     * @param  array $bindings (optional) binding array
     * @return this
     * @access public
     * @api
     */
    public function whereRaw(
        /*# string */ $clause,
        array $bindings = []
    )/*# : SelectQueryInterface */;
}

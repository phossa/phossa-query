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

namespace Phossa\Query\Statement\Clause;

/**
 * WhereInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface WhereInterface extends ClauseInterface
{
    /**
     * Generic WHERE clause with 'AND' logic
     *
     * e.g.
     * <code>
     *   // raw mode, WHERE age > 18
     *   ->where('age > 18')
     *
     *   // MODE_STRICT: field/value mode, WHERE age = 18
     *   ->where('age', 18)
     *
     *   // MODE_STRICT: operator mode, WHERE age > 18
     *   ->where('age', '>', 18)
     *
     *   // MODE_STRICT: operator 'in', WHERE age IN (10,11,12)
     *   ->where('age', 'in', [10, 11, 12])
     *
     *   // MODE_STRICT: operator 'between', WHERE age BETWEEN 10 AND 20
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
    public function where()/*# :  */;
}

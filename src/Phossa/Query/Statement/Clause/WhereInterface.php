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
     * ```php
     * // raw mode, WHERE `age` > 18
     * ->where('age > 18')
     *
     * // MODE_STRICT: field/value mode, WHERE `age` = 18
     * ->where('age', 18)
     *
     * // MODE_STRICT: operator mode, WHERE `age` > 18
     * ->where('age', 18, '>')
     *
     * // MODE_STRICT: operator 'in', WHERE `age` IN (10,11,12)
     * ->where('age', [10, 11, 12], 'in')
     *
     * // MODE_STRICT: operator 'between', WHERE `age` BETWEEN 10 AND 20
     * ->where('age', [10, 20], 'between')
     *
     * // array mode, WHERE `age` = 18 AND `gender` = 'male'
     * ->where(['age' => 18, 'gender' => 'male'])
     *
     * // associate array mode, WHERE `age` > 18 AND `score` <= 100
     * ->where(['age' => [ 18, '>' ], 'score' => [ 100, '<='] ])
     *
     * // subquery mode
     * ->where('age', $subquery, 'in')
     * ```
     *
     * @param  string|array $field field or fields
     * @param  mixed|null $value
     * @param  string $operator
     * @return $this
     * @access public
     */
    public function where($field, $value, $operator = '=');

    /**
     * Generic WHERE clause with 'OR' logic
     *
     * @param  string|array $field field or fields
     * @param  mixed|null $value
     * @param  string $operator
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhere($field, $value, $operator = '=');
}

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

use Phossa\Query\Statement\SelectInterface;

/**
 * WhereInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface WhereInterface extends ClauseInterface
{
    /**
     * Dummy placeholders
     *
     * @var    string
     */
    const SHORT_FORM    = '__SHORT_FORM__';
    const NO_VALUE      = '__NO_SUCH_VALUE__';
    const NO_OPERATOR   = '__NO_SUCH_OPERATOR__';

    /**
     * Generic WHERE clause with 'AND' logic
     *
     * ```php
     * // auto raw mode, WHERE `age` > 18
     * ->where('age > 18')
     *
     * // MODE_STRICT: col/value mode, WHERE `age` = 18
     * ->where('age', 18)
     *
     * // MODE_STRICT: operator mode, WHERE `age` > 18
     * ->where('age', '>', 18)
     *
     * // array mode, WHERE `age` = 18 AND `score` = 100
     * ->where(['age' => 18, 'score' => 100])
     *
     * // associate array mode, WHERE `age` > 18 AND `score` <= 100
     * ->where(['age' => [ '>', 18 ], 'score' => [ '<=', 100 ])
     * ```
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @param  bool $logicAnd 'AND'
     * @param  bool $whereNot 'WHERE NOT'
     * @param  bool $rawMode
     * @param  string $clause 'where' or 'having'
     * @return self
     * @access public
     */
    public function where(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false,
        /*# string */ $clause = 'where'
    );

    /**
     * Same as self::where()
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function andWhere(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE
    );

    /**
     * Generic WHERE clause with 'OR' logic
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhere(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE
    );

    /**
     * Raw mode WHERE with logic 'AND'
     *
     * @param  string $where
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereRaw($where);

    /**
     * Raw mode WHERE with logic 'OR'
     *
     * @param  string $where
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereRaw($where);

    /**
     * WHERE NOT 'AND' Logic
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNot(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE
    );

    /**
     * WHERE NOT 'OR' Logic
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNot(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE
    );

    /**
     * WHERE IN with 'AND' logic
     *
     * // MODE_STRICT: operator 'in', WHERE `age` IN (10,11,12)
     * ->whereIn('age', [10, 11, 12])
     *
     * // subquery mode
     * ->whereIn('age', $subquery)
     *
     * @param  string $col
     * @param  array $value
     * @param  bool $and logic 'and' or 'or'
     * @param  bool $not not in
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereIn($col, array $value, $and = true, $not = false);

    /**
     * WHERE IN with 'OR' logic
     *
     * @param  string $col
     * @param  array $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereIn($col, array $value);

    /**
     * WHERE NOT IN with 'AND' logic
     *
     * @param  string $col
     * @param  array $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNotIn($col, array $value);

    /**
     * WHERE NOT IN with 'OR' logic
     *
     * @param  string $col
     * @param  array $value
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNotIn($col, array $value);

    /**
     * WHERE BETWEEN with 'AND' logic
     *
     * // WHERE `age` BETWEEN 10 AND 20
     * ->whereBetween('age', 10, 20)
     *
     * @param  string $col
     * @param  mixed $val1
     * @param  mixed $val2
     * @param  bool $and and or
     * @param  bool not between
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereBetween($col, $val1, $val2, $and = true, $not = false);

    /**
     * WHERE BETWEEN with 'OR' logic
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereBetween($col, $value1, $value2);

    /**
     * WHERE NOT BETWEEN with 'AND' logic
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNotBetween($col, $value1, $value2);

    /**
     * WHERE NOT BETWEEN with 'OR' logic
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNotBetween($col, $value1, $value2);

    /**
     * WHERE IS NULL with 'AND' logic
     *
     * @param  string $col
     * @param  bool $and and or
     * @param  bool $not not null
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNull($col, $and = true, $not = false);

    /**
     * WHERE IS NULL with 'OR' logic
     *
     * @param  string $col
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNull($col);

    /**
     * WHERE IS NOT NULL with 'AND' logic
     *
     * @param  string $col
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNotNull($col);

    /**
     * WHERE IS NOT NULL with 'OR' logic
     *
     * @param  string $col
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNotNull($col);

    /**
     * WHERE EXISTS with 'AND' logic
     *
     * @param  SelectInterface $sel
     * @param  bool $and and or
     * @param  bool $not not exists
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereExists(
        SelectInterface $sel, $and = true, $not = false
    );

    /**
     * WHERE EXISTS with 'OR' logic
     *
     * @param  SelectInterface $sel
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereExists(SelectInterface $sel);

    /**
     * WHERE NOT EXISTS with 'AND' logic
     *
     * @param  SelectInterface $sel
     * @return self
     * @see    self::where()
     * @access public
     */
    public function whereNotExists(SelectInterface $sel);

    /**
     * WHERE NOT EXISTS with 'OR' logic
     *
     * @param  SelectInterface $sel
     * @return self
     * @see    self::where()
     * @access public
     */
    public function orWhereNotExists(SelectInterface $sel);
}

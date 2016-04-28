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

use Phossa\Query\Statement\StatementInterface;

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
    const NO_VALUE      = '__NO_SUCH_VALUE__';
    const NO_OPERATOR   = '__NO_SUCH_OPERATOR__';

    /**
     * Generic WHERE clause with 'AND' logic
     *
     * ```php
     * // raw mode, WHERE `age` > 18
     * ->where('age > 18')
     *
     * // MODE_STRICT: col/value mode, WHERE `age` = 18
     * ->where('age', 18)
     *
     * // MODE_STRICT: operator mode, WHERE `age` > 18
     * ->where('age', '>', 18)
     *
     * // MODE_STRICT: operator 'in', WHERE `age` IN (10,11,12)
     * ->where('age', 'in', [10, 11, 12])
     *
     * // MODE_STRICT: operator 'between', WHERE `age` BETWEEN 10 AND 20
     * ->where('age', 'between', [10, 20])
     *
     * // array mode, WHERE `age` = 18 AND `gender` = 'male'
     * ->where(['age' => 18, 'score' => 100])
     *
     * // associate array mode, WHERE `age` > 18 AND `score` <= 100
     * ->where(['age' => [ '>', 18 ], 'score' => [ '<=', 100 ])
     *
     * // subquery mode
     * ->where('age', 'in', $subquery)
     * ```
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @param  bool $logicAnd 'AND'
     * @param  bool $whereNot 'WHERE NOT'
     * @param  bool $rawMode
     * @return $this
     * @access public
     */
    public function where(
        $col,
        $operator = self::NO_OPERATOR,
        $value    = self::NO_VALUE,
        /*# bool */ $logicAnd = true,
        /*# bool */ $whereNot = false,
        /*# bool */ $rawMode  = false
    );

    /**
     * Same as self::where()
     *
     * @param  string|array $col col or cols
     * @param  mixed $operator
     * @param  mixed $value
     * @return $this
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
     * @return $this
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
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereRaw($where);

    /**
     * Raw mode WHERE with logic 'OR'
     *
     * @param  string $where
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @param  string $col
     * @param  array $value
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereIn($col, array $value);

    /**
     * WHERE IN with 'OR' logic
     *
     * @param  string $col
     * @param  array $value
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereIn($col, array $value);

    /**
     * WHERE NOT IN with 'AND' logic
     *
     * @param  string $col
     * @param  array $value
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereNotIn($col, array $value);

    /**
     * WHERE NOT IN with 'OR' logic
     *
     * @param  string $col
     * @param  array $value
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereNotIn($col, array $value);

    /**
     * WHERE BETWEEN with 'AND' logic
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereBetween($col, $value1, $value2);

    /**
     * WHERE BETWEEN with 'OR' logic
     *
     * @param  string $col
     * @param  mixed $value1
     * @param  mixed $value2
     * @return $this
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
     * @return $this
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
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereNotBetween($col, $value1, $value2);

    /**
     * WHERE IS NULL with 'AND' logic
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereNull($col);

    /**
     * WHERE IS NULL with 'OR' logic
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereNull($col);

    /**
     * WHERE IS NOT NULL with 'AND' logic
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereNotNull($col);

    /**
     * WHERE IS NOT NULL with 'OR' logic
     *
     * @param  string $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereNotNull($col);

    /**
     * WHERE EXISTS with 'AND' logic
     *
     * @param  StatementInterface|callable $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereExists($col);

    /**
     * WHERE EXISTS with 'OR' logic
     *
     * @param  StatementInterface|callable $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereExists($col);

    /**
     * WHERE NOT EXISTS with 'AND' logic
     *
     * @param  StatementInterface|callable $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function whereNotExists($col);

    /**
     * WHERE NOT EXISTS with 'OR' logic
     *
     * @param  StatementInterface|callable $col
     * @return $this
     * @see    self::where()
     * @access public
     */
    public function orWhereNotExists($col);
}

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

namespace Phossa\Query;

use Phossa\Query\Statement\RawInterface;
use Phossa\Query\Statement\SelectInterface;
use Phossa\Query\Statement\DeleteInterface;
use Phossa\Query\Statement\InsertInterface;
use Phossa\Query\Statement\UpdateInterface;
use Phossa\Query\Statement\ExpressionInterface;
use Phossa\Query\Dialect\DialectAwareInterface;
use Phossa\Query\Statement\Clause\FromInterface;

/**
 * BuilderInterface
 *
 * Build statements and manage dialect and global settings for them
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @see     DialectAwareInterface
 * @see     FromInterface
 * @see     ParameterInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsInterface, FromInterface, ParameterInterface
{
    /**
     * Create an expression
     *
     * ```php
     * $users = new Builder('Users');
     *
     * // SELECT *
     * //     FROM Users
     * //     WHERE
     * //         (age < 18 OR gender = 'female') OR
     * //         (age > 60 OR (age > 55 AND gender = 'female'))
     * $users->select()
     * ->where(
     *     $users->expr()->where('age', '<', 18)->orWhere('gender', 'female');
     * )->orWhere(
     *     $users->expr()->where('age', '>' , 60)->orWhere(
     *         $users->where('age', '>', 55)->where('gender', 'female')
     *     );
     * );
     * ```
     *
     * @return ExpressionInterface
     * @access public
     */
    public function expr()/*# : ExpressionInterface */;

    /**
     * Pass as raw, do NOT quote
     *
     * ```php
     * $builder->select()->col($builder->raw('RANGE(?, ?)', 1, 10);
     * ```
     *
     * @param  string $string
     * @return RawInterface
     * @access public
     */
    public function raw(/*# string */ $string)/*# : RawInterface */;

    /**
     * Build a SELECT statement
     *
     * Add col[s] to SELECT query. IF $col is FALSE, clear tables!!
     *
     * ```php
     *     // SELECT DISTINCT
     *     ->select()->distinct()
     *
     *     // SELECT `user_name`
     *     ->select('user_name')
     *
     *     // SELECT `user_name` AS `n`
     *     ->select('user_name', 'n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->select(['user_id', 'user_name'])
     *
     *     // SELECT `user_id`, `user_name` AS `n`
     *     ->select(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  string|array|bool $col column specification[s]
     * @param  string $colAlias alias name for $col
     * @return SelectInterface
     * @access public
     */
    public function select(
        $col = '',
        /*# string */ $colAlias = ''
    )/*# : SelectInterface */;

    /**
     * Build an INSERT statement
     *
     * @param  array $values
     * @return InsertInterface
     * @access public
     */
    public function insert(array $values = [])/*# : InsertInterface */;

    /**
     * Build an UPDATE statement
     *
     * @param  array $values
     * @return UpdateInterface
     * @access public
     */
    public function update(array $values = [])/*# : UpdateInterface */;

    /**
     * Build a DELETE statement
     *
     * @return DeleteInterface
     * @access public
     */
    public function delete()/*# : DeleteInterface */;
}

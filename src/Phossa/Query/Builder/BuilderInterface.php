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

namespace Phossa\Query\Builder;

use Phossa\Query\Clause\FromInterface;
use Phossa\Query\Statement\RawInterface;
use Phossa\Query\Statement\PreviousInterface;
use Phossa\Query\Statement\ExpressionInterface;
use Phossa\Query\Dialect\DialectAwareInterface;
use Phossa\Query\Dialect\Common\CreateInterface;
use Phossa\Query\Exception\BadMethodCallException;
use Phossa\Query\Dialect\Mysql\ReplaceStatementInterace;
use Phossa\Query\Dialect\Common\InsertStatementInterface;
use Phossa\Query\Dialect\Common\SelectStatementInterface;
use Phossa\Query\Dialect\Common\UpdateStatementInterface;
use Phossa\Query\Dialect\Common\DeleteStatementInterface;

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
interface BuilderInterface extends DialectAwareInterface, SettingsInterface, FromInterface, ParameterInterface, PreviousInterface
{
    /**
     * Create an expression
     *
     * ```php
     * $users = new Builder(new Mysql(), 'Users');
     *
     * // SELECT *
     * //     FROM Users
     * //     WHERE
     * //         (age < 18 OR gender = 'female') OR
     * //         (age > 60 OR (age > 55 AND gender = 'female'))
     * $users->select()
     * ->where(
     *     $users->expr()->where('age', '<', 18)->orWhere('gender', 'female')
     * )->orWhere(
     *     $users->expr()->where('age', '>' , 60)->orWhere(
     *         $users->where('age', '>', 55)->where('gender', 'female')
     *     )
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
     * @return SelectStatementInterface
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function select(
        $col = '',
        /*# string */ $colAlias = ''
    )/*# : SelectStatementInterface */;

    /**
     * Build an INSERT statement
     *
     * @param  array $values
     * @return InsertStatementInterface
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function insert(array $values = [])/*# : InsertStatementInterface */;

    /**
     * Build an REPLACE statement
     *
     * @param  array $values
     * @return ReplaceStatementInterace
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function replace(array $values = [])/*# : ReplaceStatementInterface */;

    /**
     * Build an UPDATE statement
     *
     * @param  array $values
     * @return UpdateStatementInterface
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function update(array $values = [])/*# : UpdateStatementInterface */;

    /**
     * Build an DELETE statement
     *
     * @param  string|array $records tables like ['users', 'sales'] etc.
     * @return DeleteStatementInterface
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function delete($records = '')/*# : DeleteStatementInterface */;

    /**
     * Build an CREATE statement
     *
     * @return CreateInterface
     * @throws BadMethodCallException if not supported
     * @access public
     */
    public function create()/*# : CreateInterface */;
}

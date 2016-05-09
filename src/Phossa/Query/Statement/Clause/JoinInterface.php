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

use Phossa\Query\Statement\ExpressionInterface;
use Phossa\Query\Dialect\Common\SelectInterface;

/**
 * JoinInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface JoinInterface
{
    /**
     * Join clause
     *
     * ```php
     * // INNER JOIN `contacts` ON `users`.`id` = `contacts`.`user_id`
     * ->join('INNER', 'contacts', 'users.id', 'contacts.user_id')
     *
     * // complex one
     * // INNER JOIN `accounts` (ON `accounts`.`id` = `users`.`account_id`
     * // OR `accounts`.`owner_id` = `users`.`id`)
     * ->join('INNER', 'accounts',
     *     $builder->on('accounts.id', 'users.account_id')
     *         ->orOn('accounts.owner_id', 'users.id')
     * )
     * ```
     *
     * @param  string $joinType
     * @param  string|SelectInterface $table
     * @param  string|ExpressionInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @param  bool $rawMode
     * @return self
     * @access public
     */
    public function realJoin(
        /*# string */ $joinType,
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# bool */ $rawMode = false
    );

    /**
     * Inner join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function join(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Inner join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function innerJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Outer join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function outerJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Left join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function leftJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Left outer join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function leftOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Right join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function rightJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Right outer join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function rightOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Full outer join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function fullOuterJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Cross join
     *
     * @param  string|SelectInterface $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function crossJoin(
        $table,
        $firstTableCol = '',
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );
}

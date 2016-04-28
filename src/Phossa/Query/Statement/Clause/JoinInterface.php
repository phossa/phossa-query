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
     * ->join('contacts', 'users.id', 'contacts.user_id')
     *
     * // complex one
     * // INNER JOIN `accounts` ON `accounts`.`id` = `users`.`account_id`
     * // OR `accounts`.`owner_id` = `users`.`id`
     * ->join('accounts',
     *     $builder->group()
     *         ->on('accounts.id', 'users.account_id')
     *         ->orOn('accounts.owner_id', 'users.id')
     * )
     * ```
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @param  string $joinType
     * @param  bool $rawMode
     * @return $this
     * @access public
     */
    public function join(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# string */ $joinType = 'INNER',
        /*# bool */ $rawMode = false
    );

    /**
     * Inner join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function innerJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Outer join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function outerJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Left join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function leftJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Left outer join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function leftOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Right join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function rightJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Right outer join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function rightOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Full outer join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function fullOuterJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Cross join
     *
     * @param  string $table
     * @param  string|SelectInterface $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function crossJoin(
        /*# string */ $table,
        $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );

    /**
     * Raw mode join
     *
     * @param  string $join
     * @return $this
     * @access public
     */
    public function joinRaw(/*# string */ $join);

    /**
     * ON
     *
     * @param  string $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @param  bool $or
     * @return $this
     * @access public
     */
    public function on(
        /*# string */ $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE,
        /*# bool */ $or = false
    );

    /**
     * OR ON
     *
     * @param  string $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return $this
     * @access public
     */
    public function orOn(
        /*# string */ $firstTableCol,
        /*# string */ $operator = WhereInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = WhereInterface::NO_VALUE
    );
}

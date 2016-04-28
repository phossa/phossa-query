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

use Phossa\Query\Statement\Select;
use Phossa\Query\Dialect\DialectInterface;
use Phossa\Query\Dialect\DialectAwareTrait;

/**
 * Query Builder
 *
 * ```php
 * // create a builder with table specified
 * $user = (new Builder())->table('User');
 *
 * // SELECT * FROM `User`
 * $select = $user->select();
 *
 * // INSERT INTO `User` ...
 * $insert = $user->insert()->...
 * ```
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     BuilderInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Builder implements BuilderInterface
{
    use SettingsTrait, DialectAwareTrait;

    /**
     * current schema
     *
     * @var    string
     * @access protected
     */
    protected $schema;

    /**
     * tables
     *
     * @var    array
     * @access protected
     */
    protected $tables = [];

    /**
     * Constructor
     *
     * ```php
     * // FROM `Users`
     * $user = new Builder('Users')
     *
     * // FROM `Users`, `Accounts`
     * $user = new Builder(['Users', 'Accounts'])
     *
     * // FROM `Users`, `Accounts` `a`
     * $user = new Builder(['Users', 'Accounts' => 'a'])
     * ```
     *
     * @param  string|array $table table to build upon
     * @param  array $settings builder settings
     * @param  DialectInterface $dialect
     * @access public
     */
    public function __construct(
        $table = '',
        array $settings = [],
        DialectInterface $dialect = null
    ) {
        $this->setSettings($settings)
             ->setDialect($dialect)
             ->from($table);
    }

    /**
     * Indicating start a grouped WHERE with '()'
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
     *     $users->group()->where('age', '<', 18)->orWhere('gender', 'female');
     * )->orWhere(
     *     $users->group()->where('age', '>' , 60)->orWhere(
     *         $users->where('age', '>', 55)->where('gender', 'female')
     *     );
     * );
     * ```
     *
     * {@inheritDoc}
     */
    public function group()/*# : SelectInterface */
    {
        return new Select($this);
    }

    /**
     * {@inheritDoc}
     */
    public function with(/*# string */ $schema)
    {
        if (null !== $this->schema) {
            $clone = clone $this;
        } else {
            $clone = $this;
        }
        $clone->schema = $schema;

        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Set table, only one table is allowed !
     *
     * ```php
     * // a user table query builder
     * $user = $builder->table('MyUserTable', 'u');
     *
     * // working on user table
     * $user->select()->...
     * ```
     *
     * {@inheritDoc}
     */
    public function from($table, /*# string */ $tableAlias = '')
    {
        // switch to a new builder if table changed
        if (!empty($this->tables)) {
            $clone = clone $this;
        } else {
            $clone = $this;
        }

        // set tables
        if (!empty($table)) {
            if (is_array($table)) {
                $clone->tables = $table;
            } else {
                $clone->tables = empty($tableAlias) ?
                    [ $table ] :
                    [ $tableAlias => $table ];
            }
        }
        return $clone;
    }

    /**
     * Alias of self::from()
     *
     * @see    self::from()
     */
    public function table($table, /*# string */ $tableAlias = '')
    {
        return $this->from($table, $tableAlias);
    }

    /**
     * {@inheritDoc}
     */
    public function select(
        $col = '',
        /*# string */ $colAlias = ''
    )/*# : SelectInterface */ {

        // SELECT statement
        $select = new Select($this);

        // set tables
        if (count($this->tables)) {
            $select->from($this->tables);
        }

        // set columns
        if (func_num_args() > 0) {
            $select->col(
                func_get_arg(0),
                func_num_args() > 1 ? func_get_arg(1) : ''
            );
        }

        return $select;
    }

    /**
     * {@inheritDoc}
     */
    public function insert(array $values = [])/*# : InsertInterface */
    {

    }

    /**
     * {@inheritDoc}
     */
    public function update(array $values = [])/*# : UpdateInterface */
    {

    }

    /**
     * {@inheritDoc}
     */
    public function delete()/*# : DeleteInterface */
    {

    }
}

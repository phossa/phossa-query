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

use Phossa\Query\Statement\Raw;
use Phossa\Query\Dialect\Common;
use Phossa\Query\Message\Message;
use Phossa\Query\Statement\Expression;
use Phossa\Query\Builder\SettingsTrait;
use Phossa\Query\Builder\ParameterTrait;
use Phossa\Query\Statement\RawInterface;
use Phossa\Query\Statement\PreviousTrait;
use Phossa\Query\Dialect\DialectInterface;
use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\DialectAwareTrait;
use Phossa\Query\Statement\ExpressionInterface;
use Phossa\Query\Dialect\Common\CreateInterface;
use Phossa\Query\Exception\BadMethodCallException;
use Phossa\Query\Dialect\Common\SelectStatementInterface;
use Phossa\Query\Dialect\Common\InsertStatementInterface;
use Phossa\Query\Dialect\Common\UpdateStatementInterface;
use Phossa\Query\Dialect\Common\DeleteStatementInterface;

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
    use SettingsTrait, DialectAwareTrait, ParameterTrait, PreviousTrait;

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
        $this->combineSettings($settings)
             ->setDialect($dialect ?: new Common())
             ->from($table);
    }

    /**
     * {@inheritDoc}
     */
    public function expr()/*# : ExpressionInterface */
    {
        return new Expression($this);
    }

    /**
     * {@inheritDoc}
     */
    public function raw(/*# string */ $string)/*# : RawInterface */
    {
        // get values from argument list
        if (func_num_args() > 1) {
            $values = func_get_args();
            array_shift($values);

            // replacement
            $pat = $rep = [];
            foreach ($values as $val) {
                $pat[] = '/\?/';
                $rep[] = $this->generatePlaceholder($val);
            }

            return new Raw(preg_replace($pat, $rep, $string, 1), $this);
        } else {
            return new Raw($string, $this);
        }
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
                    [$table] : [$tableAlias => $table];
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
    )/*# : SelectStatementInterface */ {

        // SELECT statement
        $select = $this->getDialect()->select($this);

        // prevous statement ?
        if ($this->hasPrevious()) {
            $select->setPrevious($this->getPrevious());
            $this->setPrevious(null);

        } else {
            // inherit tables
            if (false !== $col && count($this->tables)) {
                $select->from($this->tables);
            }
        }

        // set columns
        if (!empty($col)) {
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
    public function insert(array $values = [])/*# : InsertStatementInterface */
    {
        // INSERT statement
        $insert = $this->getDialect()->insert($this);

        // set table
        if (count($this->tables)) {
            $insert->into($this->tables[array_keys($this->tables)]);
        }

        // set cols
        if (!empty($values)) {
            $insert->set($values);
        }

        return $insert;
    }

    /**
     * {@inheritDoc}
     */
    public function replace(array $values = [])/*# : ReplaceStatementInterface */
    {
        // REPLACE statement
        $dialect = $this->getDialect();
        if (!method_exists($dialect, 'replace')) {
            throw new BadMethodCallException(
                Message::get(Message::BUILDER_UNKNOWN_METHOD, 'replace'),
                Message::BUILDER_UNKNOWN_METHOD
            );
        }

        $replace = $dialect->replace($this);

        // set table
        if (count($this->tables)) {
            $replace->into($this->tables[array_keys($this->tables)]);
        }

        // set cols
        if (!empty($values)) {
            $replace->set($values);
        }

        return $replace;
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $values = [])/*# : UpdateStatementInterface */
    {
        // UPDATE statement
        $update = $this->getDialect()->update($this);

        // set table
        if (count($this->tables)) {
            $update->table($this->tables);
        }

        // set cols
        if (!empty($values)) {
            $update->set($values);
        }

        return $update;
    }

    /**
     * {@inheritDoc}
     */
    public function delete()/*# : DeleteStatementInterface */
    {
        // DELETE statement
        $delete = $this->getDialect()->delete($this);

        // set table
        if (count($this->tables)) {
            $delete->table($this->tables);
        }

        return $delete;
    }

    /**
     * {@inheritDoc}
     */
    public function create()/*# : CreateInterface */
    {
        return $this->getDialect()->create($this);
    }
}

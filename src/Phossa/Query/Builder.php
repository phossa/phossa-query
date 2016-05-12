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
use Phossa\Query\Statement\StatementInterface;

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
     * // builder with default table `users`
     * $users = new Builder('users')
     *
     * // builder with defult tables:  `users` and `accounts` AS `a`
     * $builder = new Builder(['users', 'accounts' => 'a'])
     *
     * // change default settings & dialect
     * $builder = new Builder('', ['autoQuote' => false], new Mysql());
     * ```
     *
     * @param  string|array $table table[s] to build upon
     * @param  array $settings builder settings
     * @param  DialectInterface $dialect default dialect is `Common`
     * @access public
     */
    public function __construct(
        $table = '',
        array $settings = [],
        DialectInterface $dialect = null
    ) {
        // settings
        $this->combineSettings($settings);

        // default to Common
        $this->setDialect($dialect ?: new Common());

        // set default table if any
        if (!empty($table)) {
            $this->from($table);
        }
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
     * Set default table[s] for this builder
     *
     * If table[s] was set, return a cloned builder with the new default table.
     *
     * ```php
     * // a user table query builder
     * $user = $builder->table('user', 'u');
     *
     * // working on user table
     * $user->select()->...
     * ```
     *
     * {@inheritDoc}
     */
    public function table($table, /*# string */ $tableAlias = '')
    {
        // fix table
        if (empty($table)) {
            $table = [];
        } else {
            if (!is_array($table)) {
                $table = empty($tableAlias) ? [$table] :
                    [$table => $tableAlias];
            }
        }

        // clone the builder if table different
        if ($table != $this->tables) {
            $clone = empty($this->tables) ? $this : (clone $this);
            $clone->tables = $table;
            return $clone;
        } else {
            return $this;
        }
    }

    /**
     * Alias of self::table()
     *
     * @see    self::table()
     */
    public function from($table, /*# string */ $tableAlias = '')
    {
        return $this->table($table, $tableAlias);
    }

    /**
     * Set $col to FALSE if do NOT want table pass to $select
     *
     * {@inheritDoc}
     */
    public function select(
        $col = '',
        /*# string */ $colAlias = ''
    )/*# : SelectStatementInterface */ {
        /* @var $select SelectStatementInterface */
        $select = $this->getDialectStatement('select', false !== $col);

        // set columns/fields
        if (!empty($col)) {
            $select->col($col, $colAlias);
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
            $insert->into($this->tables[array_keys($this->tables)[0]]);
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
            $replace->into($this->tables[array_keys($this->tables)[0]]);
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

    /**
     * Get the statement object
     *
     * @param  string $method
     * @param  bool $setTable set with builder tables
     * @return StatementInterface
     * @throws BadMethodCallException if no method found for this dialect
     * @access protected
     */
    protected function getDialectStatement(
        /*# string */ $method,
        /*# bool */ $setTable
    )/*# StatementInterface */ {
        // dialect
        $dialect = $this->getDialect();

        // check method
        if (!method_exists($dialect, $method)) {
            throw new BadMethodCallException(
                Message::get(Message::BUILDER_UNKNOWN_METHOD, $method),
                Message::BUILDER_UNKNOWN_METHOD
            );
        }

        /* @var $statement StatementInterface */
        $statement = call_user_func([$dialect, $method], $this);

        // prevous statement like in UNION
        if ($this->hasPrevious()) {
            $statement->setPrevious($this->getPrevious());
            $this->setPrevious(null);

        // set tables
        } elseif ($setTable && count($this->tables)) {
            $statement->from($this->tables);
        }

        return $statement;
    }
}

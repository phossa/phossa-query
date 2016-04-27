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
     * // FROM `users`
     * $user = new Builder('users')
     *
     * // FROM `users`, `accounts`
     * $user = new Builder(['users', 'accounts'])
     *
     * // FROM `users`, `accounts` `a`
     * $user = new Builder(['users', 'accounts' => 'a'])
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
             ->table($table);
    }

    /**
     * {@inheritDoc}
     */
    public function table($table, /*# string */ $tableAlias = '')
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
                    [ $table => $tableAlias ];
            }
        }
        return $clone;
    }

    /**
     * {@inheritDoc}
     */
    public function select()/*# : SelectInterface */
    {
        // SELECT statement
        $select = new Select($this);

        // set tables
        if (count($this->tables)) {
            $select->from($this->tables);
        }

        // set fields
        if (func_num_args() > 0) {
            $select->field(
                func_get_arg(0),
                func_num_args() > 1 ? func_get_arg(1) : ''
            );
        }

        return $select;
    }
}

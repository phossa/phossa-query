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

namespace Phossa\Query\Dialect\Common;

use Phossa\Query\Clause\TableOptionInterface;
use Phossa\Query\Statement\StatementInterface;
use Phossa\Query\Clause\ColDefinitionInterface;
use Phossa\Query\Clause\TableConstraintInterface;

/**
 * CreateTableInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface CreateTableStatementInterface extends StatementInterface, ColDefinitionInterface, TableConstraintInterface, TableOptionInterface
{
    /**
     * CREATE TEMPORARY TABLE ...
     *
     * @return self
     * @access public
     */
    public function temp();

    /**
     * CREATE TABLE IF NOT EXISTS ...
     *
     * @return self
     * @access public
     */
    public function ifNotExists();

    /**
     * CREATE TABLE ... LIKE
     *
     * @param  string $tableName
     * @return self
     * @access public
     */
    public function like(/*# string */ $tableName);

    /**
     * CREATE TABLE ... SELECT ...
     *
     * @return SelectStatementInterface
     * @access public
     */
    public function select()/*# : SelectStatementInterface */;
}

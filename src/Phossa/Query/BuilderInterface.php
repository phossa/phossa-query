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

use Phossa\Query\Statement\SelectInterface;
use Phossa\Query\Statement\DeleteInterface;
use Phossa\Query\Statement\InsertInterface;
use Phossa\Query\Statement\UpdateInterface;
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
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderInterface extends DialectAwareInterface, SettingsInterface, FromInterface
{
    /**
     * Indicating start a group with '()'
     *
     * @return SelectInterface
     * @access public
     */
    public function group()/*# : SelectInterface */;

    /**
     * Set schema
     *
     * @param  string $schema
     * @return $this
     * @access public
     */
    public function with(/*# string */ $schema);

    /**
     * Get current schema
     *
     * @return string|null
     * @access public
     */
    public function getSchema();

    /**
     * Build a SELECT statement
     *
     * Add col[s] to SELECT query
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
     * @param  string|array $col column specification[s]
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

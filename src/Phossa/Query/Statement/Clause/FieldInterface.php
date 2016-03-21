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
 * FieldInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FieldInterface extends ClauseInterface
{
    /**
     * Set DISTINCT
     *
     * @return this
     * @access public
     * @api
     */
    public function distinct();

    /**
     * Add field[s] to query
     *
     * ```php
     *     // SELECT `user_name`
     *     ->field('user_name')
     *
     *     // SELECT `user_name` AS `n`
     *     ->field('user_name', 'n')
     *
     *     // SELECT `user_id`, `user_name`
     *     ->field(['user_id', 'user_name'])
     *
     *     // SELECT `user_id`, `user_name` AS `n`
     *     ->field(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  string|array $field field specification
     * @param  string $as field alias name
     * @return this
     * @access public
     * @api
     */
    public function field($field, /*# string */ $as = '');
}

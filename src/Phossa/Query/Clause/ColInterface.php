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

namespace Phossa\Query\Clause;

/**
 * ColInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface ColInterface extends ClauseInterface
{
    /**
     * Set DISTINCT
     *
     * @return self
     * @access public
     */
    public function distinct();

    /**
     * Add col[s] to query
     *
     * ```php
     * // SELECT `user_name`
     * ->col('user_name')
     *
     * // SELECT `user_name` AS `n`
     * ->col('user_name', 'n')
     *
     * // SELECT `user_id`, `user_name`
     * ->col(['user_id', 'user_name'])
     *
     * // SELECT `user_id`, `user_name` AS `n`
     * ->col(['user_id', 'user_name' => 'n'])
     * ```
     *
     * @param  mixed $col column specification[s]
     * @param  string $colAlias column alias name
     * @return self
     * @access public
     */
    public function col(
        $col = '',
        /*# string */ $colAlias = ''
    );

    /**
     * Alias of col()
     *
     * @param  mixed $col column specification[s]
     * @param  string $colAlias column alias name
     * @return self
     * @see    self::col()
     * @access public
     */
    public function field(
        $col = '',
        /*# string */ $colAlias = ''
    );

    /**
     * Raw mode col
     *
     * ```php
     * // SELECT COUNT(user_id) AS cnt
     * ->colRaw('COUNT(user_id)', 'cnt')
     *
     * // array type
     * ->colRaw(['COUNT(user_id)' => 'cnt'])
     * ```
     *
     * @param  string|array $string
     * @param  string $alias
     * @return self
     * @access public
     */
    public function colRaw($string, /*# string */ $alias = '');

    /**
     * Alias of colRaw()
     *
     * @param  string|array $string
     * @param  string $alias
     * @return self
     * @access public
     */
    public function fieldRaw($string, /*# string */ $alias = '');
}

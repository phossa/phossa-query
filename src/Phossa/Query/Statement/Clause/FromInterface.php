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
 * FromInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FromInterface extends ClauseInterface
{
    /**
     * From table[s]
     *
     * If array provided, overwrite exiting from[s]
     *
     * <code>
     *     // FROM `users`
     *     ->from('users')
     *
     *     // FROM `users` `u`
     *     ->from('users', 'u')
     *
     *     // FROM `users`, `accounts`
     *     ->from(['users', 'accounts'])
     *
     *     // FROM `users`, `accounts` `a`
     *     ->from(['users', 'accounts' => 'a'])
     * </code>
     *
     * @param  string|array $table table specification[s]
     * @param  string $as (optional) table alias name
     * @return static
     * @access public
     * @api
     */
    public function from($table, /*# string */ $as = '');
}

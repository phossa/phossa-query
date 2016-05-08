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

use Phossa\Query\Statement\SelectInterface;

/**
 * FromInterface
 *
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
     * If array provided, overwrite exiting from[s] !!
     *
     * ```php
     * // FROM `users`
     * select()->from('users')
     *
     * // FROM `users` `u`
     * select()->from('users', 'u')
     *
     * // FROM `users`, `accounts`
     * select()->from(['users', 'accounts'])
     *
     * // FROM `users`, `accounts` `a`
     * select()->from(['users', 'accounts' => 'a'])
     *
     * // FROM (SELECT id FROM users WHERE id < 10) AS sub
     * select()->from($users->select('id')->where('id < 10'), 'sub');
     * ```
     *
     * @param  string|array|SelectInterface $table table specification[s]
     * @param  string $tableAlias alias to be used later in the query
     * @return this
     * @access public
     */
    public function from(
        $table,
        /*# string */ $tableAlias = ''
    );

    /**
     * Alias to self::from()
     *
     * @see    self::from()
     */
    public function table(
        $table,
        /*# string */ $tableAlias = ''
    );
}

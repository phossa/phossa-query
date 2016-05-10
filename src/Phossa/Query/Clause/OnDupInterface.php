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
 * OnDupInterface
 *
 * ON DUPLICATE KEY UPDATE for mysql
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OnDupInterface extends ClauseInterface
{
    /**
     * ON DUPLICATE KEY UPDATE
     *
     * @param  string $col column name
     * @param  string $expr expression string
     * @return self
     * @access public
     */
    public function onDup(/*# string */ $col, /*# string */ $expr);
}

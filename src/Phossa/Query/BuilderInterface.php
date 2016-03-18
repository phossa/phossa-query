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

/**
 * BuilderInterface
 *
 * Build statements and manage dialect and global settings for them
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @see     Dialect\DialectAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderInterface extends Dialect\DialectAwareInterface, SettingsInterface
{
    /**
     * Set tables
     *
     * @param  string|array $tables table to use
     * @return static
     * @access public
     * @api
     */
    public function table($tables);
    
    /**
     * Build SELECT statement
     *
     * @param  array $settings SELECT related extra settings
     * @return Statement\SelectStatement
     * @access public
     * @api
     */
    public function select(
        array $settings = []
    )/*# : Statement\SelectStatement */;
}

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

namespace Phossa\Query\Statement;

/**
 * OutputInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OutputInterface
{
    /**
     * Return the SQL base on settings and the dialect
     *
     * @param  array $settings settings
     * @param  bool $replace replace placeholders
     * @return string
     * @access public
     */
    public function getStatement(
        array $settings = [],
        /*# bool */ $replace = true
    )/*# : string */;

    /**
     * Get the statement with default settings & dialect
     *
     * @return string
     * @access public
     */
    public function __toString()/*# : string */;
}

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

use Phossa\Query\SettingsInterface;
use Phossa\Query\Dialect\DialectInterface;

/**
 * StatementInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface StatementInterface extends SettingsInterface
{
    /**
     * Return the statement base on settings and the dialect

     *
     * @param  array $settings settings
     * @param  DialectInterface $dialect
     * @return string
     * @access public
     * @api
     */
    public function getStatement(
        array $settings = [],
        DialectInterface $dialect = null
    )/*# : string */;

    /**
     * Get the statement with default settings & dialect
     *
     * @return string
     * @access public
     * @api
     */
    public function __toString()/*# : string */;
}

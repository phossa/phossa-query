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

use Phossa\Query\Builder\SettingsInterface;
use Phossa\Query\Clause\BeforeAfterInterface;
use Phossa\Query\Dialect\DialectAwareInterface;

/**
 * StatementInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface StatementInterface extends DialectAwareInterface, SettingsInterface, BuilderAwareInterface, ParameterAwareInterface, PreviousInterface, BeforeAfterInterface
{
    /**
     * Return the SQL base on settings and the dialect
     *
     * @param  array $settings settings
     * @param  bool $replace replace placeholders
     * @return string
     * @access public
     */
    public function getSql(
        array $settings = [],
        /*# bool */ $replace = true
    )/*# : string */;

    /**
     * Return the SQL statement type
     *
     * @return string
     * @access public
     */
    public function getType()/*# : string */;

    /**
     * Get the statement with default settings & dialect
     *
     * @return string
     * @access public
     */
    public function __toString()/*# : string */;
}

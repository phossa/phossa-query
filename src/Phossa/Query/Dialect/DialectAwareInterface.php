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

namespace Phossa\Query\Dialect;

/**
 * DialectAwareInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DialectAwareInterface
{
    /**
     * Set the dialect
     *
     * @param  DialectInterface $dialect
     * @return static
     * @access public
     * @api
     */
    public function setDialect(DialectInterface $dialect = null);

    /**
     * Get the dialect, if not set yet, create and return the default
     *
     * @return DialectInterface
     * @access public
     * @api
     */
    public function getDialect();
}

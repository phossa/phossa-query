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
     * @return $this
     * @access public
     */
    public function setDialect(DialectInterface $dialect);

    /**
     * Get the dialect
     *
     * @return DialectInterface
     * @access public
     */
    public function getDialect()/*# : DialectInterface */;
}

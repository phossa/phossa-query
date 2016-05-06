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
 * ParameterInterface
 *
 * Dealing with positioned parameters
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface ParameterInterface
{
    /**
     * Return binding values
     *
     * @return array
     * @access public
     */
    public function getBindings()/*# : array */;

    /**
     * Set default escape function
     *
     * @param  callable $function
     * @return $this
     * @access public
     */
    public function setEscapeFunction(callable $function);
}

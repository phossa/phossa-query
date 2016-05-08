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
 * PreviousInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface PreviousInterface
{
    /**
     * Set previous statement
     *
     * @param  StatementInterface $previous
     * @return this
     * @access public
     */
    public function setPrevious(StatementInterface $previous);

    /**
     * Has previous statement
     *
     * @return bool
     * @access public
     */
    public function hasPrevious()/*# : bool */;

    /**
     * Get previous statement
     *
     * @return StatementInterface
     * @access public
     */
    public function getPrevious()/*# : StatementInterface */;
}

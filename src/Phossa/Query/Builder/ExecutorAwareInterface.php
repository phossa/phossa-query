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

namespace Phossa\Query\Builder;

/**
 * ExecutorAwareInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.3
 * @since   1.0.3 added
 */
interface ExecutorAwareInterface
{
    /**
     * Normally, it is a third party query executor
     *
     * @param  object $executor
     * @return self
     * @access public
     */
    public function setExecutor($executor);

    /**
     * Get the executor
     *
     * @return null|object
     * @access public
     */
    public function getExecutor();
}

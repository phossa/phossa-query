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

use Phossa\Query\Exception\BadMethodCallException;

/**
 * ExecutorAwareInterface
 *
 * For any unknown method call, pass it to the executor
 *
 * @package package_name
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
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
     * Pass any unkown method like 'get()' to the executor
     *
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call(/*# string */ $method, array $arguments);
}

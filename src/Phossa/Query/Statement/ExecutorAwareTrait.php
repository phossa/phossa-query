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

use Phossa\Query\Message\Message;
use Phossa\Query\Exception\BadMethodCallException;

/**
 * ExecutorAwareTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExecutorAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ExecutorAwareTrait
{
    /**
     * the query executor
     *
     * @var    object
     * @access protected
     */
    protected $executor;

    /**
     * Normally, it is a third party query executor
     *
     * @param  object $executor
     * @return self
     * @access public
     */
    public function setExecutor($executor)
    {
        $this->executor = $executor;
        return $this;
    }

    /**
     * Pass any unkown method like 'get()' to the executor
     *
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call(/*# string */ $method, array $arguments)
    {
        if ($this->executor && method_exists($this->executor, $method)) {
            $sql = $this->getStatement();
            $val = $this->getBindings();
            return call_user_func_array(
                [$this->executor, $method],
                [$sql, $val]
            );
        }
        throw new BadMethodCallException(
            Message::get(Message::BUILDER_UNKNOWN_METHOD, $method),
            Message::BUILDER_UNKNOWN_METHOD
        );
    }

    /**
     * Return the SQL base on settings and the dialect
     *
     * @param  array $settings settings
     * @param  bool $replace replace placeholders
     * @return string
     * @access public
     */
    abstract public function getStatement(
        array $settings = [],
        /*# bool */ $replace = true
    )/*# : string */;

    /**
     * Return binding values
     *
     * @return array
     * @access public
     */
    abstract public function getBindings()/*# : array */;
}

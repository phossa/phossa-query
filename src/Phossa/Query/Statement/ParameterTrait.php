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
 * ParameterTrait
 *
 * Dealing with positioned parameters
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ParameterInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ParameterTrait
{
    /**
     * Binding values
     *
     * @var    array
     * @access protected
     */
    protected $bindings = [];

    /**
     * escape the values
     *
     * @var    callable
     * @access protected
     */
    protected $escape_func;

    /**
     * store positioned parameters
     *
     * @var    array
     * @access protected
     * @staticvar
     */
    protected static $positioned_params = [];

    /**
     * position count
     *
     * @var    int
     * @access protected
     */
    protected $position_count = 0;

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */
    {
        return $this->bindings;
    }

    /**
     * Set default escape function
     *
     * @param  callable $function
     * @return $this
     * @access public
     */
    public function setEscapeFunction(callable $function)
    {
        $this->escape_func = $function;
        return $this;
    }

    /**
     * Return a placeholder for the value
     *
     * @param  mixed $value
     * @return string the placeholder
     * @access protected
     */
    protected function getPlaceholder($value)/*# : string */
    {
        $oid = spl_object_hash($this);
        $key = '__' . $oid . ++$this->position_count . '__';
        static::$positioned_params[$key] = $value;

        return $key;
    }

    /**
     * Replace placeholders with '?' or real value
     *
     * @param  string $sql
     * @param  bool $positionedParam  '?' or replace with value directly
     * @return string replaced sql
     * @access protected
     */
    protected function rebindParam(
        /*# string */ $sql,
        /*# bool */ $positionedParam = false
    ) {
        $bindings = &$this->bindings;
        $params   = &static::$positioned_params;

        // escape callable
        $escape   = $this->getEscapeCallable();

        // real function
        $function = function($v) use ($positionedParam, &$bindings, $escape) {
            // bypass ':param' and '?'
            if ('?' === $v || is_string($v) && isset($v[0]) && ':' === $v[0]) {
                return $v;

            // use positioned '?'
            } elseif ($positionedParam) {
                $bindings[] = $v;
                return '?';

            // use value, but NOT escaping int or float
            } elseif (is_numeric($v) && !is_string($v)) {
                return $v;

            // use value, but escape it
            } else {
                return $escape($v);
            }
        };

        // replace placeholders with '?' or real value
        return preg_replace_callback(
            '/\b__[0-9a-z]++__\b/',
            function($m) use (&$params, $function) {
                return $function($params[$m[0]]);
            }, $sql);
    }

    /**
     * Get the DB escape callable
     *
     * @return callable
     * @access protected
     */
    protected function getEscapeCallable()/*# : callable */
    {
        if (null === $this->escape_func) {
            $this->escape_func = function($v) {
                return "'" . str_replace("'", "\\'", (string) $v) . "'";
            };
        }
        return $this->escape_func;
    }
}

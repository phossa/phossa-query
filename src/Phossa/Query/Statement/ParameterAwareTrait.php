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

use Phossa\Query\BuilderInterface;

/**
 * ParameterAwareTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ParameterAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ParameterAwareTrait
{
    /**
     * Binding values
     *
     * @var    array
     * @access protected
     */
    protected $bindings = [];

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */
    {
        return $this->bindings;
    }

    /**
     * Replace placeholders in the SQL with '?' or real value
     *
     * @param  string $sql
     * @param  bool $positionedParam  '?' or replace with value directly
     * @param  callable $escapeFunction escape|quote value function
     * @return string replaced sql
     * @access protected
     */
    protected function bindValues(
        /*# string */ $sql,
        /*# bool */ $positionedParam = false,
        callable $escapeFunction = null
    ) {
        $bindings = &$this->bindings;
        $escape   = $this->getEscapeCallable($escapeFunction);
        $params   = $this->getBuilder()->getPlaceholderMapping();

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

            // use value, but escape it @todo boolean?
            } else {
                return $escape($v);
            }
        };

        // replace placeholders with '?' or real value
        return preg_replace_callback(
            '/\b__PH_[0-9]++__\b/',
            function($m) use (&$params, $function) {
                return $function($params[$m[0]]);
            }, $sql);
    }

    /**
     * Get the database escape callable
     *
     * @param  null|callable $escapeFunction defult escape function
     * @return callable
     * @access protected
     */
    protected function getEscapeCallable($escapeFunction)/*# : callable */
    {
        if (null === $escapeFunction) {
            return function($v) {
                return "'" . str_replace("'", "\\'", (string) $v) . "'";
            };
        }
        return $escapeFunction;
    }

    /**
     * Generate and return a placeholder for the value
     *
     * @param  mixed $value
     * @return string the placeholder
     * @access protected
     */
    protected function getPlaceholder($value)/*# : string */
    {
        return $this->getBuilder()->generatePlaceholder($value);
    }

    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    abstract public function getBuilder()/*# : BuilderInterface */;
}

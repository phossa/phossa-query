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

use Phossa\Query\Builder\BuilderInterface;

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
     * Flush bindings
     *
     * @return self
     * @access protected
     */
    protected function resetBindings()
    {
        $this->bindings = [];
        return $this;
    }

    /**
     * Replace placeholders in the SQL with '?' or real value
     *
     * @param  string $sql
     * @param  array $settings current settings
     * @return string replaced sql
     * @access protected
     */
    protected function bindValues(
        /*# string */ $sql,
        array $settings
    )/*# : string */ {
        $bindings = &$this->bindings;
        $escape   = $this->getEscapeCallable($settings['escapeFunction']);
        $params   = $this->getBuilder()->getPlaceholderMapping();

        // real function
        $function = function($v) use ($settings, &$bindings, $escape) {
            // positioend parameters
            if ($settings['positionedParam']) {
                $bindings[] = $v;
                return '?';

            // named parameters
            } elseif ($settings['namedParam'] && isset($v[0]) && ':' == $v[0]) {
                return $v;

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

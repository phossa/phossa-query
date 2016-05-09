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
 * DialectAwareTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait DialectAwareTrait
{
    /**
     * dialect
     *
     * @var    DialectInterface
     * @access protected
     */
    protected $dialect;

    /**
     * store of dialect related methods and its arguments
     *
     * @var    array
     * @access protected
     */
    protected $dialect_methods = [];

    /**
     * {@inheritDoc}
     */
    public function setDialect(DialectInterface $dialect)
    {
        $this->dialect = $dialect;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDialect()/*# : DialectInterface */
    {
        return $this->dialect;
    }

    /**
     * {@inheritDoc}
     */
    public function __call($method, array $args)
    {
        if (!isset($this->dialect_methods[$method])) {
            $this->dialect_methods[$method] = [];
        }
        $this->dialect_methods[$method][] = $args;
        return $this;
    }
}

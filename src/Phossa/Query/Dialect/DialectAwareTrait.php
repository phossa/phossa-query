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
     * default dialect
     *
     * @static
     * @var    string
     * @access public
     */
    public static $default_dialect = 'Mysql';

    /**
     * dialect
     *
     * @var    DialectInterface
     * @access protected
     */
    protected $dialect;

    /**
     * @inheritDoc
     */
    public function setDialect(DialectInterface $dialect = null)
    {
        $this->dialect = $dialect;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDialect()
    {
        if (is_null($this->dialect)) {
            $class = __NAMESPACE__ . '\\' . static::$default_dialect;
            $this->dialect = new $class;
        }
        return $this->dialect;
    }
}

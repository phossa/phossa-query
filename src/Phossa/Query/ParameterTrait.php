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

namespace Phossa\Query;

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
     * store positioned parameters
     *
     * @var    array
     * @access protected
     * @staticvar
     */
    protected static $positioned_params = [];

    /**
     * builder-wide position count
     *
     * @var    int
     * @access protected
     * @staticvar
     */
    protected static $positioned_count  = 0;

    /**
     *{@inheritDoc}
     */
    public function generatePlaceholder($value)/*# : string */
    {
        $key = '__PH_' . ++self::$positioned_count . '__';
        self::$positioned_params[$key] = $value;
        return $key;
    }

    /**
     * {@inheritDoc}
     */
    public function getPlaceholderMapping()/*# : array */
    {
        return self::$positioned_params;
    }
}

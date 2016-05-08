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
 * Pass as raw string
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     RawInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Raw implements RawInterface
{
    /**
     * raw string
     *
     * @var    string
     * @access protected
     */
    protected $str = '';

    public function __construct(/*# string */ $string)
    {
        $this->str = (string) $string;
    }

    public function __toString()
    {
        return $this->str;
    }
}

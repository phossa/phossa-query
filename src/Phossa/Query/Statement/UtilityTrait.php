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

use Phossa\Query\Statement\RawInterface;
use Phossa\Query\Dialect\DialectInterface;

/**
 * UtilityTrait
 *
 * Utilities for the statement
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait UtilityTrait
{
    /**
     * If $string contains any char other than '[0-9a-zA-Z$_.]', we consider
     * it is a raw string case
     *
     * @param  string|object $string
     * @return bool
     * @access protected
     */
    protected function isRaw($str)/*# : bool */
    {
        if (is_string($str)) {
            return (bool) preg_match('/[^0-9a-zA-Z\$_.]/', $str);
        } elseif (is_object($str) && $str instanceof RawInterface) {
            return true;
        }
        return false;
    }

    /**
     * Quote SQL identifier base on settings
     *
     * @param  string $string
     * @return string
     * @access protected
     */
    protected function quote(/*# string */ $str)/*# : string */
    {
        return $this->dialect->quote(
            $str,
            $this->settings['autoQuote'] ?
            DialectInterface::QUOTE_YES :
            DialectInterface::QUOTE_NO
        );
    }

    /**
     * If SPACE found ,quote it anyway
     *
     * @param  string $string
     * @return string
     * @access protected
     */
    protected function quoteSpace(/*# string */ $str)/*# : string */
    {
        return $this->dialect->quote(
            $str,
            DialectInterface::QUOTE_SPACE | (
                $this->settings['autoQuote'] ?
                DialectInterface::QUOTE_YES :
                DialectInterface::QUOTE_NO
            )
        );
    }
}

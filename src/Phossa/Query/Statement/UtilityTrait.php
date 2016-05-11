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
     * @param  string|object $str
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
     * @param  string $str
     * @return string
     * @access protected
     */
    protected function quote(/*# string */ $str)/*# : string */
    {
        return $this->getDialect()->quote(
            $str,
            $this->getSettings()['autoQuote'] ?
            DialectInterface::QUOTE_YES :
            DialectInterface::QUOTE_NO
        );
    }

    /**
     * If SPACE found ,quote it anyway
     *
     * @param  string $str
     * @return string
     * @access protected
     */
    protected function quoteSpace(/*# string */ $str)/*# : string */
    {
        return $this->getDialect()->quote(
            $str,
            DialectInterface::QUOTE_SPACE | (
                $this->getSettings()['autoQuote'] ?
                DialectInterface::QUOTE_YES :
                DialectInterface::QUOTE_NO
            )
        );
    }

    /**
     * Quote 'name(4) ASC' as '`name`(4) ASC' as used in index creation
     * @param  string $str
     * @return string
     * @access protected
     */
    protected function quoteLeading(/*# string */ $str)/*# : string */
    {
        $parts = preg_split('/([^0-9a-zA-Z_.])/', $str, 5,
            \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY);
        $first = array_shift($parts);
        return $this->quote($first) . join('', $parts);
    }

    /**
     * Get current settings
     *
     * @return array
     * @access public
     */
    abstract public function getSettings()/*# : array */;

    /**
     * Get the dialect
     *
     * @return DialectInterface
     * @access public
     */
    abstract public function getDialect()/*# : DialectInterface */;
}

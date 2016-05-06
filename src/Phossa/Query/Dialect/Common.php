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
 * Standard Query Language dialect
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Common implements DialectInterface
{

    /**
     * quote prefix
     *
     * @var    string
     * @access protected
     */
    protected $quote_prefix = '"';

    /**
     * quote suffix
     *
     * @var    string
     * @access protected
     */
    protected $quote_suffix = '"';

    /**
     * {@inheritDoc}
     */
    public function quote(
        /*# string */ $string,
        /*# bool */ $quote = DialectInterface::QUOTE_YES
    )/*# : string */ {
        $pref = $this->quote_prefix;
        $suff = $this->quote_suffix;

        // space found
        if (preg_match("/[ \n(),]/", $string)) {
            // quote it anyway
            if ($quote & DialectInterface::QUOTE_SPACE) {
                return sprintf('%s%s%s', $pref, $string, $suff);

            // abort
            } else {
                return $string;
            }
        }

        if ($quote & DialectInterface::QUOTE_YES) {
            $string = preg_replace_callback(
                '/\b([0-9a-zA-Z\$_]++)\b/',
                function($m) use ($pref, $suff) {
                    return sprintf('%s%s%s', $pref, $m[1], $suff);
                },
                $string
            );
        }
        return $string;
    }
}

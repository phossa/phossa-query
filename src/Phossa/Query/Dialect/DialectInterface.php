<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Dialect;

/**
 * DialectInterface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DialectInterface
{
    /**#@+
     * quote
     *
     * @const
     */

    /**
     * do NOT quote anything
     */
    const QUOTE_NO      = 0;

    /**
     * auto quote, string with spaces not quoted
     */
    const QUOTE_YES     = 1;

    /**
     * quote string with spaces also, event if QUOTE_NO set
     */
    const QUOTE_SPACE   = 2;

    /**#@-*/

    /**
     * Set output settings
     *
     * @param  array $settings set output settings
     * @return this
     * @access public
     * @api
     */
    public function setSettings(
        array $settings
    )/*# : DialectInterface */;

    /**
     * Get output settings
     *
     * @param  array $settings (optional) also merge with these settings
     * @return array
     * @access public
     * @api
     */
    public function getSettings(
        array $settings = []
    )/*# : array */;

    /**
     * Quote identifier
     *
     * @param  string|object $input input string
     * @param  int $quote 0 no, 1 yes, 2 quote spaces
     * @return string
     * @access public
     * @api
     */
    public function quoteIdentifier(
        $input,
        /*# int */ $quote = DialectInterface::QUOTE_YES
    )/*# : string */;

    /**
     * Build and return the sql string
     *
     * @param  \Phossa\Query\QueryInterface $query the query object
     * @param  array $settings (optional) output settings
     * @return string
     * @throws void
     * @access public
     * @api
     */
    public function buildSql(
        \Phossa\Query\QueryInterface $query,
        array $settings = []
    )/*# : string */;
}

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
     * @param  string $input input string
     * @param  bool $autoQuote true or false
     * @return string
     * @access public
     * @api
     */
    public function quoteIdentifier(
        /*# string */ $input,
        /*# bool */ $autoQuote = true
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

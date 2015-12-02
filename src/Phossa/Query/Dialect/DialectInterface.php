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
     * Quote or not
     *
     * @param  bool $quote quote or not
     * @return this
     * @access public
     * @api
     */
    public function setQuote(
        /*# bool */ $quote = true
    )/*# : DialectInterface */;

    /**
     * Beautify the result or not
     *
     * @param  bool $beautify beautify or not
     * @return this
     * @access public
     * @api
     */
    public function setBeautify(
        /*# bool */ $beautify = true
    )/*# : DialectInterface */;

    /**
     * Quote identifier
     *
     * @param  string $input input string
     * @return string
     * @access public
     * @api
     */
    public function quoteIdentifier(
        /*# string */ $input
    )/*# : string */;

    /**
     * Build and return the sql string
     *
     * @param  \Phossa\Query\QueryInterface $query the query object
     * @param  string $prefix (optional) table prefix if any
     * @return string
     * @throws void
     * @access public
     * @api
     */
    public function buildSql(
        \Phossa\Query\QueryInterface $query,
        /*# string */ $prefix = ''
    )/*# : string */;
}

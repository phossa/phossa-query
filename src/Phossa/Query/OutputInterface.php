<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * Query output interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OutputInterface
{
    /**
     * Return the statement for $dialect
     *
     * Default output settings are
     * <code>
     *     $settings = [
     *          'autoQuote'     => true,
     *          'tablePrefix'   => '',
     *          'seperator'     => ' ',
     *          'indent'        => '    ',
     *     ];
     * </code>
     *
     * @param  array $settings (optional) output settings
     * @param  Dialect\DialectInterface $dialect (optional) insert dialect
     * @return string
     * @access public
     * @api
     */
    public function getStatement(
        array $settings = [],
        Dialect\DialectInterface $dialect = null
    )/*# : string */;

    /**
     * Return binding values
     *
     * @param  void
     * @return array
     * @access public
     * @api
     */
    public function getBindings()/*# : array */;

    /**
     * Return the query string
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function __toString()/*# string */;
}

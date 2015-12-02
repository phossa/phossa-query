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
 * DialectCapableInterface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DialectCapableInterface
{
    /**
     * Set the dialect
     *
     * @param  DialectInterface $dialect specific dialect
     * @return this
     * @access public
     * @api
     */
    public function setDialect(
        DialectInterface $dialect
    )/*# : DialectCapableInterface */;

    /**
     * Get the dialect. if not set, return a new Common dialect
     *
     * @param  void
     * @return DialectInterface
     * @access public
     * @api
     */
    public function getDialect()/*# : DialectInterface */;
}

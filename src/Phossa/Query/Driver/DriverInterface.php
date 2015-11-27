<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Driver;

/**
 * DriverInterface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DriverInterface
{
    /**
     * Set identifer quotation
     *
     * @param  bool $quote quote or not
     * @return this
     * @access public
     * @api
     */
    public function setQuote(
        /*# bool */ $quote = true
    )/*# : DriverInterface */;

    /**
     * Get current quote status
     *
     * @param  void
     * @return bool
     * @access public
     * @api
     */
    public function getQuote()/*# : bool */;
}

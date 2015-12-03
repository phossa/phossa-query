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
 * Builder's config interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\DialectCapableInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface ConfigInterface extends Dialect\DialectCapableInterface
{
    /**
     * Set builder configs
     *
     * @param  array $configs new configs
     * @return this
     * @access public
     * @api
     */
    public function setConfigs(
        array $configs
    )/*# : ConfigInterface */;

    /**
     * Get builder configs
     *
     * @param  void
     * @return array
     * @access public
     * @api
     */
    public function getConfigs()/*# : array */;
}

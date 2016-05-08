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

namespace Phossa\Query;

/**
 * SettingsInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Dialect\DialectAwareInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SettingsInterface
{
    /**
     * Set settings
     *
     * @param  array $settings
     * @return self
     * @access public
     */
    public function setSettings(array $settings);

    /**
     * Combine with settings
     *
     * @param  array $settings
     * @return self
     * @access public
     */
    public function combineSettings(array $settings);

    /**
     * Get current settings
     *
     * @return array
     * @access public
     */
    public function getSettings()/*# : array */;
}

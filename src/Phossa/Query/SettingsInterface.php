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
     * Settings
     *
     * ```php
     * $settings = [
     *     'autoQuote'      => true,
     *     'tablePrefix'    => 'tbl_',
     *     'columnPrefix'   => 'col_',
     *     'indent'         => '    ',
     * ];
     * ```
     *
     * @param  array $settings
     * @return $this
     * @access public
     */
    public function setSettings(array $settings);

    /**
     * Get builder settings
     *
     * @return array
     * @access public
     */
    public function getSettings()/*# : array */;
}

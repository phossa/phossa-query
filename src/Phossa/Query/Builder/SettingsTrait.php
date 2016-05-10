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

namespace Phossa\Query\Builder;

/**
 * SettingsTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SettingsInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait SettingsTrait
{
    /**
     * default settings
     *
     * @var    array
     * @access protected
     */
    protected $settings = [
        // auto quote db identifier
        'autoQuote'         => true,

        // replace value with '?'
        'positionedParam'   => false,

        // clause seperator
        'seperator'         => ' ',

        // subline indention
        'indent'            => '',

        // escape/quote function
        'escapeFunction'    => null,
    ];

    /**
     * {@inheritDoc}
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function combineSettings(array $settings)
    {
        $this->settings = array_replace($this->settings, $settings);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettings()/*# : array */
    {
        return $this->settings;
    }
}

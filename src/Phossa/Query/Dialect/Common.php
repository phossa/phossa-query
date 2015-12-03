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

use Phossa\Query\Sql;

/**
 * Common dialect
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\DialectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Common implements DialectInterface
{
    /**
     * dialect output settings
     *
     * @var    array
     * @access protected
     */
    protected $settings = [
        'autoQuote'     => true,
        'tablePrefix'   => '',
        'seperator'     => ' ',
        'indent'        => '',
    ];

    /**
     * {@inheritDoc}
     */
    public function setSettings(
        array $settings
    )/*# : DialectInterface */ {
        $this->settings = array_replace($this->settings, $settings);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettings(
        array $settings = []
    )/*# : array */ {
        return array_replace($this->settings, $settings);
    }

    /**
     * {@inheritDoc}
     */
    public function quoteIdentifier(
        /*# string */ $input,
        /*# bool */ $autoQuote = true
    )/*# : string */ {
        if ($autoQuote) {
            // quote chars
            $prefix = $suffix = '"';
            if (func_num_args() > 2) {
                $args = func_get_args();
                $prefix = $args[2];
                $suffix = isset($args[3]) ? $args[3] : $prefix;
            }

            return sprintf('%s%s%s', $prefix, $input, $suffix);
        } else {
            return $input;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function buildSql(
        \Phossa\Query\QueryInterface $query,
        array $settings = []
    )/*# : string */ {
        // current settings
        $s = $this->getSettings($settings);
        $s['si']  = $s['seperator'] . $s['indent'];
        $s['csi'] = ',' . $s['si'];

        // build SELECT
        if ($query instanceof Sql\SelectQueryInterface) {
            return $this->buildSelect($query->getQueryParts(), $s);
        }
    }

    /**
     * Build SELECT
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     */
    protected function buildSelect(array &$parts, array &$settings)
    {
        $sql = [];

        // field
        $sql[] = $this->buildField($parts, $settings);

        // from
        $sql[] = $this->buildFrom($parts, $settings);

        $prefix = "SELECT" .
                  (isset($parts['distinct']) ? " DISTINCT" : "") .
                  $settings['si'];

        return $prefix . join($settings['seperator'], $sql);
    }

    /**
     * Build SELECT fields
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     * @api
     */
    protected function buildField(array &$parts, array &$settings)
    {
        $fields = [];

        if (isset($parts['fld'])) {
            $quote  = $settings['autoQuote'];
            foreach($parts['fld'] as $c) {
                if (is_string($c)) {
                    $fields[] = $this->quoteIdentifier($c, $quote);
                } else {
                    $fields[] = sprintf(
                        "%s AS %s",
                        $this->quoteIdentifier($c[0], $quote),
                        $this->quoteIdentifier($c[1], $quote)
                    );
                }
            }
        } else {
            $fields[] = '*';
        }

        return join($settings['csi'], $fields);
    }

    /**
     * Build FROM part
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     * @api
     */
    protected function buildFrom(array &$parts, array $settings)
    {
        $clause = [];

        foreach($parts['tbl'] as $f) {
            $quote  = $settings['autoQuote'];
            if (is_string($f)) {
                $clause[] = $this->quoteIdentifier($f, $quote);
            } else {
                $clause[] = sprintf(
                    "%s %s",
                    $this->quoteIdentifier($f[0], $quote),
                    $this->quoteIdentifier($f[1], $quote)
                );
            }
        }
        return "FROM" . $settings['si'] . join($settings['csi'], $clause);
    }
}

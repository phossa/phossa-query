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
        $input,
        /*# int */ $quote = DialectInterface::QUOTE_YES
    )/*# : string */ {

        // wrap non-string and return
        if (!is_string($input)) {
            return '('. $input . ')';
        }

        // complex case
        $complex = false;
        if (preg_match("/[ \n(),]/", $input)) {
            $complex = true;
            if ($quote & DialectInterface::QUOTE_SPACE) {
                $quote |= DialectInterface::QUOTE_YES;
            } else {
                return $input;
            }
        }

        // quote
        if ($quote & DialectInterface::QUOTE_YES) {
            // quote chars
            $prefix = $suffix = '"';
            if (func_num_args() > 2) {
                $args = func_get_args();
                $prefix = $args[2];
                $suffix = isset($args[3]) ? $args[3] : $prefix;
            }

            // dot expr
            if (!$complex &&
                preg_match('/^([^.]++)[.]([^.]++)$/', $input, $m)
            ) {
                return sprintf(
                    '%s%s%s.%s%s%s',
                    $prefix, $m[1], $suffix,
                    $prefix, $m[2], $suffix
                );
            } else {
                return sprintf('%s%s%s', $prefix, $input, $suffix);
            }

        // no quote
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

        // into
        $sql[] = $this->buildInto($parts, $settings);

        // from
        $sql[] = $this->buildFrom($parts, $settings);

        $prefix = "SELECT" .
                  (isset($parts['distinct']) ? " DISTINCT" : "") .
                  $settings['si'];

        return $prefix . join($settings['seperator'],
            array_filter($sql, function($var) {
                return !empty($var);
            }));
    }

    /**
     * Build SELECT fields
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     */
    protected function buildField(array &$parts, array &$settings)
    {
        $fields = [];

        if (isset($parts['fld'])) {
            $quote  = $settings['autoQuote'] ?
                DialectInterface::QUOTE_YES :
                DialectInterface::QUOTE_NO;
            foreach($parts['fld'] as $c) {
                if (is_array($c)) {
                    $fields[] = sprintf(
                        "%s AS %s",
                        $this->quoteIdentifier($c[0], $quote),
                        $this->quoteIdentifier(
                            $c[1], $quote | DialectInterface::QUOTE_SPACE
                        )
                    );
                } else {
                    $fields[] = $this->quoteIdentifier($c, $quote);
                }
            }
        } else {
            $fields[] = '*';
        }

        return join($settings['csi'], $fields);
    }

    /**
     * Build INTO part
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     */
    protected function buildInto(array &$parts, array $settings)
    {
        if (!isset($parts['into'])) return '';

        return "INTO" .
            $settings['si'] .
            $this->quoteIdentifier($parts['into'], $settings['autoQuote']);
    }

    /**
     * Build FROM part
     *
     * @param  array &$parts sql parts
     * @param  array &$settings current settings
     * @return string
     * @access protected
     */
    protected function buildFrom(array &$parts, array $settings)
    {
        $clause = [];

        // missing FROM clause
        if (!isset($parts['tbl'])) return '';

        foreach($parts['tbl'] as $f) {
            $quote  = $settings['autoQuote'] ?
                DialectInterface::QUOTE_YES :
                DialectInterface::QUOTE_NO;
            if (is_array($f)) {
                $clause[] = sprintf(
                    "%s %s",
                    $this->quoteIdentifier($f[0], $quote),
                    $this->quoteIdentifier(
                        $f[1], $quote | DialectInterface::QUOTE_SPACE
                    )
                );
            } else {
                $clause[] = $this->quoteIdentifier($f, $quote);
            }
        }
        return "FROM" . $settings['si'] . join($settings['csi'], $clause);
    }
}

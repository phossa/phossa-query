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
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Common implements DialectInterface
{
    /**
     * quote or not
     *
     * @var    bool
     * @access protected
     */
    protected $quote    = true;

    /**
     * beautify result
     *
     * @var    bool
     * @type   bool
     * @access protected
     */
    protected $beautify = false;

    /**
     * table prefix
     *
     * @var    string
     * @access protected
     */
    protected $prefix   = '';

    /**
     * {@inheritDoc}
     */
    public function setQuote(
        /*# bool */ $quote = true
    )/*# : DialectInterface */ {
        $this->quote = $quote;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setBeautify(
        /*# bool */ $beautify = true
    )/*# : DialectInterface */ {
        $this->beautify = $beautify;
    }

    /**
     * {@inheritDoc}
     */
    public function quoteIdentifier(
        /*# string */ $input
    )/*# : string */ {
        // no quote
        if (!$this->quote) return $input;

        // quote chars
        $prefix = $suffix = '"';
        if (func_num_args() > 1) {
            $args = func_get_args();
            $prefix = $args[1];
            $suffix = isset($args[2]) ? $args[2] : $prefix;
        }

        return sprintf('%s%s%s', $prefix, $input, $suffix);
    }

    /**
     * {@inheritDoc}
     */
    public function buildSql(
        \Phossa\Query\QueryInterface $query,
        /*# string */ $prefix = ''
    )/*# : string */ {
        // set table prefix
        $this->prefix = $prefix;

        // build SELECT
        if ($query instanceof Sql\SelectInterface) {
            return $this->buildSelect($query->getQueryParts());
        }
    }

    /**
     * Build SELECT
     *
     * @param  array &$parts sql parts
     * @return string
     * @access protected
     */
    protected function buildSelect(
        array &$parts
    ) {
        $sql = [];

        // field
        $sql[] = $this->buildField($parts);

        // from
        $sql[] = $this->buildFrom($parts);

        $prefix = "SELECT" .
                  (isset($parts['distinct']) ? " DISTINCT" : "") .
                  ($this->beautify ? "\n    " : " ");
        $join   = $this->beautify ? "\n" : " ";

        return $prefix . join($join, $sql);
    }

    /**
     * Build SELECT fields
     *
     * @param  array &$parts sql parts
     * @return string
     * @access protected
     * @api
     */
    protected function buildField(array &$parts)
    {
        $fields = [];

        if (isset($parts['fld'])) {
            foreach($parts['fld'] as $c) {
                if (is_string($c)) {
                    $fields[] = $this->quoteIdentifier($c);
                } else {
                    $fields[] = sprintf(
                        "%s AS %s",
                        $this->quoteIdentifier($c[0]),
                        $this->quoteIdentifier($c[1])
                    );
                }
            }
        } else {
            $fields[] = '*';
        }

        $join = $this->beautify ? ",\n    " : ", ";
        return join($join, $fields);
    }

    /**
     * Build FROM part
     *
     * @param  array &$parts sql parts
     * @return string
     * @access protected
     * @api
     */
    protected function buildFrom(array &$parts)
    {
        $clause = [];

        foreach($parts['tbl'] as $f) {
            if (is_string($f)) {
                $clause[] = $this->quoteIdentifier($f);
            } else {
                $clause[] = sprintf(
                    "%s %s",
                    $this->quoteIdentifier($f[0]),
                    $this->quoteIdentifier($f[1])
                );
            }
        }

        $prefix = $this->beautify ? "FROM\n    " : "FROM ";
        $join   = $this->beautify ? ",\n    " : ", ";
        return $prefix . join($join, $clause);
    }
}

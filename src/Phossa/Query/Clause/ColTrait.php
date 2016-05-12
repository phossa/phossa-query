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

namespace Phossa\Query\Clause;

/**
 * ColTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ColInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ColTrait
{
    /**
     * DISTINCT
     *
     * @var    bool
     * @access protected
     */
    protected $clause_distinct = false;

    /**
     * FIELDS or COLUMNS
     *
     * @var    array
     * @access protected
     */
    protected $clause_column   = [];

    /**
     * {@inheritDoc}
     */
    public function distinct()
    {
        $this->clause_distinct = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function col(
        $col = '',
        /*# string */ $colAlias = ''
    ) {
        return $this->realCol($col, $colAlias);
    }

    /**
     * {@inheritDoc}
     */
    public function field(
        $col = '',
        /*# string */ $colAlias = ''
    ) {
        return $this->realCol($col, $colAlias);
    }

    /**
     * {@inheritDoc}
     */
    public function colRaw($string, /*# string */ $alias = '')
    {
        return $this->realCol($string, $alias, true);
    }

    /**
     * {@inheritDoc}
     */
    public function fieldRaw($string, /*# string */ $alias = '')
    {
        return $this->realCol($string, $alias, true);
    }

    /**
     * {@inheritDoc}
     */
    protected function realCol(
        $col = '',
        /*# string */ $colAlias = '',
        $rawMode = false
    ) {
        // col array definition
        if (is_array($col)) {
            foreach ($col as $key => $val) {
                if (is_int($key)) {
                    $key = $val;
                    $val = '';
                }
                $this->realCol($key, $val, $rawMode);
            }

        // clear columns
        } else if ('*' === $col) {
            $this->clause_column = [];

        // add columns
        } elseif (!empty($col)) {
            // auto raw mode detect
            $rawMode = $rawMode ?: $this->isRaw($col);

            if ('' === $colAlias) {
                $this->clause_column[] = [$rawMode, $col];
            } else {
                $this->clause_column[(string) $colAlias] = [$rawMode, $col];
            }
        }
        return $this;
    }

    /**
     * Build columns
     *
     * @return array
     * @access protected
     */
    protected function buildCol()/*# : array */
    {
        $result = [];

        // all cols
        if (empty($this->clause_column)) {
            $result[] = '*';

        // specific cols
        } else {
            foreach ($this->clause_column as $as => $col) {
                // col alias
                $alias = is_int($as) ? '' : (' AS ' . $this->quoteSpace($as));

                // rawMode ?
                $field = $col[0] ? $col[1] : $this->quote($col[1]);

                // function ?
                if (isset($col[2])) {
                    $field = sprintf($col[2], $field);
                }
                $result[] = $field . $alias;
            }
        }
        return $result;
    }

    /**
     * Build DISTINCT
     *
     * @return array
     * @access protected
     */
    protected function buildDistinct()/*# : array */
    {
        $result = [];
        if ($this->clause_distinct) {
            $result[] = 'DISTINCT';
        }
        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function isRaw($str)/*# : bool */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
    abstract protected function quoteSpace(/*# string */ $str)/*# : string */;
}

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

namespace Phossa\Query\Statement\Clause;

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
     * {@inheritDoc}
     */
    public function distinct()
    {
        $this->clauses['distinct'] = true;
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
    public function select(
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
            unset($this->clauses['col']);

            // add columns
        } elseif (!empty($col)) {
            // auto raw mode detect
            $rawMode = $rawMode ?: $this->isRaw($col);

            if ('' === $colAlias) {
                $this->clauses['col'][] = [$rawMode, $col];
            } else {
                $this->clauses['col'][(string) $colAlias] = [$rawMode, $col];
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
        if (!isset($this->clauses['col']) || empty($this->clauses['col'])) {
            $result[] = '*';

        // specific cols
        } else {
            foreach ($this->clauses['col'] as $as => $col) {
                // col alias
                $alias = is_int($as) ? '' : (' AS ' . $this->quoteSpace($as));

                // $col[0]: rawMode
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
        if (isset($this->clauses['distinct'])) {
            $result[] = 'DISTINCT';
        }
        return $result;
    }

    abstract protected function isRaw($str)/*# : bool */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
    abstract protected function quoteSpace(/*# string */ $str)/*# : string */;
}

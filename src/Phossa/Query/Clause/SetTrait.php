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
 * SetTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     SetInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait SetTrait
{
    /**
     * SET column values
     *
     * @var    array
     * @access protected
     */
    protected $clause_data = [];

    /**
     * SET column name
     *
     * @var    array
     * @access protected
     */
    protected $clause_set  = [];

    /**
     * Current data row number
     *
     * @var    array
     * @access protected
     */
    protected $clause_rownum = 0;

    /**
     * Set column values
     *
     * @param  string|array $col
     * @param  mixed value scalar or Select query
     * @return self
     * @access public
     */
    public function set($col, $value = ClauseInterface::NO_VALUE)
    {
        if (is_array($col)) {
            return $this->setWithArrayData($col);
        }

        // update column name
        if (!isset($this->clause_set[$col])) {
            $this->clause_set[$col] = true;
        }

        // store data by row
        if (ClauseInterface::NO_VALUE !== $value) {
            $this->clause_data[$this->clause_rownum][$col] = $value;
        }

        return $this;
    }

    /**
     * Batch SET
     *
     * @param  array $data
     * @return self
     * @access protected
     */
    protected function setWithArrayData(array $data)
    {
        // multiple rows
        if (isset($data[0])) {
            foreach ($data as $row) {
                is_array($row) ? $this->setWithArrayData($row) :
                    $this->set($row);
            }
            return $this;

        // multiple values
        } else {
            foreach ($data as $col => $val) {
                $this->set($col, $val);
            }
        }

        // increase rownum
        $this->clause_rownum++;

        return $this;
    }

    /**
     * Build SET
     *
     * @return array
     * @access protected
     */
    protected function buildSet()/*# : array */
    {
        if ('UPDATE' === $this->getType()) {
            return $this->buildUpdateSet();
        } else {
            return $this->buildInsertSet();
        }
    }

    /**
     * Build ( ... )
     *
     * @return array
     * @access protected
     */
    protected function buildInsertSet()/*# : array */
    {
        $result = [];

        if (empty($this->clause_set)) {
            return $result;
        }

        // build cols first
        $cols = [];
        foreach (array_keys($this->clause_set) as $col) {
            $cols[] = $this->quote($col);
        }
        $result[] = '(' . join(', ', $cols) . ')';

        return $result;
    }

    /**
     * Build SET ... = ..., ... = ...
     *
     * @return array
     * @access protected
     */
    protected function buildUpdateSet()/*# : array */
    {
        $result = [];

        // build set
        $data = $this->clause_data[0];
        foreach ($data as $col => $val) {
            $result[] = $this->quote($col) . ' = ' . $this->processValue($val);
        }

        return $result;
    }

    /**
     * Build VALUES ( ... )
     *
     * @return array
     * @access protected
     */
    protected function buildValues()/*# : array */
    {
        $result = [];
        $cols = array_keys($this->clause_set);

        $maxRow = count($this->clause_data) - 1;
        foreach ($this->clause_data as $num => $row) {
            $values = [];
            foreach ($cols as $col) {
                if (isset($row[$col])) {
                    $values[] = $this->processValue($row[$col]);
                } else {
                    $values[] = $this->getSettings()['useNullAsDefault'] ?
                        'NULL' : 'DEFAULT';
                }
            }
            $result[] = '(' . join(', ', $values) . ')' . ($num !== $maxRow ?
                ',' : '');
        }

        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;

    /**
     * Return the SQL statement type
     *
     * from StatementInterface
     *
     * @return string
     * @access public
     */
    abstract public function getType()/*# : string */;

    /**
     * Get current settings
     *
     * @return array
     * @access public
     */
    abstract public function getSettings()/*# : array */;
}

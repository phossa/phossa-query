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

use Phossa\Query\Statement\SelectInterface;
/**
 * FromTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     FromInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait FromTrait
{
    /**
     * {@inheritDoc}
     */
    public function from(
        $table,
        /*# string */ $tableAlias = ''
    )/* : FromInterface */ {
        if (is_array($table)) {
            foreach ($table as $key => $val) {
                if (is_int($key)) {
                    $key = $val;
                    $val = '';
                }
                $this->from($key, $val);
            }
        } else {
            if (empty($tableAlias)) {
                $this->clauses['from'][] = $table;
            } else {
                $this->clauses['from'][(string) $tableAlias] = $table;
            }
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function table(
        $table,
        /*# string */ $tableAlias = ''
    )/* : FromInterface */ {
        return $this->from($table, $tableAlias);
    }

    /**
     * Build FROM
     *
     * @return array
     * @access protected
     */
    protected function buildFrom()/*# : array */
    {
        $result = [];
        if (isset($this->clauses['from'])) {
            foreach ($this->clauses['from'] as $as => $tbl) {
                // table alias
                $alias = is_int($as) ? '' : (' AS ' . $this->quoteSpace($as));

                // subselect
                if (is_object($tbl) && $tbl instanceof SelectInterface) {
                    $tbl = '(' . $tbl->getSql([], $this->getDialect(), false) . ')';

                // normal table
                } else {
                    $tbl = $this->quote($tbl);
                }
                $result[] = $tbl . $alias;
            }
        }
        return $result;
    }

    /**
     * Get current table name
     *
     * @param  bool $returnAlias return alias is ok
     * @return string
     * @access protected
     */
    protected function getTableName($returnAlias = false)/*# : string */
    {
        $result = '';
        if (isset($this->clauses['from'])) {
            foreach ($this->clauses['from'] as $k => $v) {
                if (!is_int($k) && $returnAlias) {
                    return $k;
                } else {
                    return $v;
                }
            }
        }
        return $result;
    }

    /**
     * Split "users u" into "users" and alias "u"
     *
     * @param  string $table
     * @return array
     * @access protected
     */
    protected function splitAlias(/*# string */ $string)/*# : array */
    {
        return preg_split('/\s+/', $string, 2, PREG_SPLIT_NO_EMPTY);
    }

    abstract public function getDialect()/*# : DialectInterface */;
    abstract protected function quote(/*# string */ $str)/*# : string */;
    abstract protected function quoteSpace(/*# string */ $str)/*# : string */;
}

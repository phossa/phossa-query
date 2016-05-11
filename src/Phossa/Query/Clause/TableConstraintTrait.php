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
 * TableConstraintTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     TableConstraintInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait TableConstraintTrait
{
    use ColDefinitionTrait;

    /**
     * table constraints
     *
     * @var    array
     * @access protected
     */
    protected $tbl_constraint = [];

    /**
     * {@inheritDoc}
     */
    public function primaryKey(
        array $colNames,
        /*# string */ $extraClause = ''
    ) {
        $this->tbl_constraint['primary'] = [$colNames, $extraClause];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function uniqueKey(array $colNames, /*# string */ $extraClause = '')
    {
        if (!isset($this->tbl_constraint['unique'])) {
            $this->tbl_constraint['unique'] = [];
        }
        $this->tbl_constraint['unique'][] = [$colNames, $extraClause];
        return $this;
    }

    /**
     * Create a constraint
     *
     * @param  string $string
     * @return self
     * @access public
     */
    public function constraint(/*# string */ $string)
    {
        if (!isset($this->tbl_constraint['other'])) {
            $this->tbl_constraint['other'] = [];
        }
        $this->tbl_constraint['other'][] = $string;
        return $this;
    }

    /**
     * Build table constraints
     *
     * @return array
     * @access protected
     */
    protected function buildTblConst()/*# : array */
    {
        $result = $this->buildCol();

        // primary
        if (isset($this->tbl_constraint['primary'])) {
            $p = $this->tbl_constraint['primary'];
            $result[] = 'PRIMARY KEY (' .
                join(', ', $this->quoteIndex($p[0])) . ')' .
                (empty($p[1]) ? '' : " $p[1]");
        }

        // unique
        if (isset($this->tbl_constraint['unique'])) {
            foreach ($this->tbl_constraint['unique'] as $uniq) {
                $result[] = 'UNIQUE (' .
                    join(', ', $this->quoteIndex($uniq[0])) . ')' .
                    (empty($uniq[1]) ? '' : " $uniq[1]");
            }
        }

        // other constraints
        if (isset($this->tbl_constraint['other'])) {
            foreach ($this->tbl_constraint['other'] as $const) {
                $result[] = $const;
            }
        }

        return $result;
    }

    /**
     * quote the index names in the array
     *
     * @param  array $cols
     * @return array
     * @access protected
     */
    protected function quoteIndex(array $cols)/*# : array */
    {
        $q = [];
        foreach ($cols as $col) {
            $q[] = $this->quoteLeading($col);
        }
        return $q;
    }

    /* utilities from UtilityTrait */
    abstract protected function quoteLeading(/*# string */ $str)/*# : string */;
}

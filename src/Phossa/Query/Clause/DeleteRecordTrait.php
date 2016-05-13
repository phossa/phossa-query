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
 * DeleteRecordTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DeleteRecordInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait DeleteRecordTrait
{
    /**
     * @var    array
     * @access protected
     */
    protected $clause_records = [];

    /**
     * {@inheritDoc}
     */
    public function record($table)
    {
        $this->clause_records = is_array($table) ? $table : [$table];
        return $this;
    }

    /**
     * Build table to delete
     *
     * @return array
     * @access protected
     */
    protected function buildRecord()/*# : array */
    {
        $res = [];
        foreach ($this->clause_records as $tbl) {
            $res[] = $this->quote($tbl) . '.*';
        }
        if (!empty($res)) {
            return [join(', ', $res)];
        } else {
            return [];
        }
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

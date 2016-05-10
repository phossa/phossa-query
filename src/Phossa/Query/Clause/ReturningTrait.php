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
 * ReturningTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ReturningInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ReturningTrait
{
    /**
     * RETURNINGs
     *
     * @var    array
     * @access protected
     */
    protected $clause_returning = [];

    /**
     * {@inheritDoc}
     */
    public function returning($col)
    {
        if (is_array($col)) {
            $this->clause_returning = array_merge($this->clause_returning, $col);
        } else {
            $this->clause_returning[] = $col;
        }
        return $this;
    }

    /**
     * Build RETURNING
     *
     * @return array
     * @access protected
     */
    protected function buildReturning()/*# : array */
    {
        $result = [];
        foreach ($this->clause_returning as $ret) {
            $result[] = $this->quote($ret);
        }
        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

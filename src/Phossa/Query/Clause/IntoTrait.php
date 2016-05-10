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
 * IntoTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     IntoInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait IntoTrait
{
    /**
     * INTO TABLE
     *
     * @var    string
     * @access protected
     */
    protected $clause_into = '';

    /**
     * Insert into table
     *
     * @param  string $table
     * @return self
     * @access public
     */
    public function into(/*# string */ $table)
    {
        $this->clause_into = $table;
        return $this;
    }

    /**
     * Build INTO
     *
     * @return array
     * @access protected
     */
    protected function buildInto()/*# : array */
    {
        $result = [];
        if ($this->clause_into) {
            $result[] = $this->quote($this->clause_into);
        }
        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

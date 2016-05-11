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
 * TableOptionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     TableOptionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait TableOptionTrait
{
    /**
     * table options
     *
     * @var    array
     * @access protected
     */
    protected $tbl_option = [];

    /**
     * {@inheritDoc}
     */
    public function tblOption(/*# string */ $string)
    {
        $this->tbl_option[] = $string;
        return $this;
    }

    /**
     * Build table options
     *
     * @return array
     * @access protected
     */
    protected function buildTblOpt()/*# : array */
    {
        $result = [];

        foreach ($this->tbl_option as $opt) {
            $result[] = $opt;
        }
        if (empty($result)) {
            $result[] = '';
        }

        return $result;
    }
}

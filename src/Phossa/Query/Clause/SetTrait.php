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

use Phossa\Query\Clause\WhereInterface;

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
     * COLUMNS
     *
     * @var    array
     * @access protected
     */
    protected $clause_cols  = [];

    /**
     * Insert into table
     *
     * @param  string|array $col
     * @param  mixed value scalar or Select query
     * @return self
     * @access public
     */
    public function set($col, $value = WhereInterface::NO_VALUE)
    {
        if (is_string($col)) {
            $this->clause_cols[$col] = $value;
        } elseif (is_array($col)) {

        }
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
        $result = [];
        return $result;
    }
}

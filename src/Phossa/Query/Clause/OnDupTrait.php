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
 * OnDupTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     OnDupInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait OnDupTrait
{
    /**
     * ON DUP
     *
     * @var    array
     * @access protected
     */
    protected $clause_ondup = [];

    /**
     * {@inheritDoc}
     */
    public function onDup(/*# string */ $col, /*# string */ $expr)
    {
        $this->clause_ondup[$col] = $expr;
        return $this;
    }

    /**
     * Build ON DUP
     *
     * @return array
     * @access protected
     */
    protected function buildOnDup()/*# : array */
    {
        $result = [];
        foreach ($this->clause_ondup as $col => $expr) {
            $result[] = $col . ' = ' . $expr;
        }
        return $result;
    }
}

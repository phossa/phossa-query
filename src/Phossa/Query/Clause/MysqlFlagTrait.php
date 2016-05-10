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
 * MysqlFlagTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     MysqlFlagInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait MysqlFlagTrait
{
    /**
     * Mysql flags
     *
     * @var    array
     * @access protected
     */
    protected $clause_flags = [];

    /**
     * {@inheritDoc}
     */
    public function addFlag(/*# string */ $flagName, /*# bool */ $enable = true)
    {
        $name = strtoupper($flagName);
        $this->clause_flags[$name] = $enable;
        return $this;
    }

    /**
     * Build FLAG
     *
     * @return array
     * @access protected
     */
    protected function buildFlag()/*# : array */
    {
        $res = [];
        foreach ($this->clause_flags as $name => $status) {
            if ($status) {
                $res[] = $name;
            }
        }
        if (!empty($res)) {
            return ['/*! ' . join(' ', $res) . ' */'];
        } else {
            return [];
        }
    }
}

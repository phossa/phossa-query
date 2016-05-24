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
 * ColDefinitionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ColDefinitionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ColDefinitionTrait
{
    use ValueTrait;

    /**
     * column
     *
     * @var    array
     * @access protected
     */
    protected $col_defs = [];

    /**
     * {@inheritDoc}
     */
    public function addCol(
        /*# string */ $colName,
        /*# string */ $colType
    ) {
        $def = [
            'name' => $colName,
            'type' => $colType
        ];
        $this->col_defs[] = $def;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function notNull(/*# string */ $conflictClause = '')
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        $col['notNull'] = $conflictClause;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function defaultValue($value, /*# bool */ $raw = false)
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        $col['default'] = [$value, $raw];
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function autoIncrement()
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        $col['autoincrement'] = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function primary(/*# string */ $conflictClause = '')
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        $col['primary'] = $conflictClause;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function unique(/*# string */ $conflictClause = '')
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        $col['unique'] = $conflictClause;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function colConstraint(/*# string */ $string)
    {
        $col = &$this->col_defs[count($this->col_defs) - 1];
        if (!isset($col['constraint'])) {
            $col['constraint'] = [];
        }
        $con = &$col['constraint'];
        $con[] = $string;
        return $this;
    }

    /**
     * Build column definitions
     *
     * @return array
     * @access protected
     */
    protected function buildCol()/*# : array */
    {
        $result = [];

        foreach ($this->col_defs as $col) {
            $res = [];
            // name
            $res[] = $this->quote($col['name']);

            // type
            $res[] = $col['type'];

            // not null ?
            if (isset($col['notNull'])) {
                $res[] = 'NOT NULL' .
                    ($col['notNull'] ? (' '.$col['notNull']) : '');
            }

            // default ?
            if (isset($col['default'])) {
                $res[] = 'DEFAULT ' . ($col['default'][1] ? $col['default'][0] :
                    $this->processValue($col['default'][0]));
            }

            // auto
            if (isset($col['autoincrement'])) {
                $res[] = 'AUTO_INCREMENT';
            }

            // unique
            if (isset($col['unique'])) {
                $res[] = 'UNIQUE' .
                    ($col['unique'] ? (' ' . $col['unique']) : '');
            }

            // primary
            if (isset($col['primary'])) {
                $res[] = 'PRIMARY KEY' .
                    ($col['primary'] ? (' ' . $col['primary']) : '');
            }

            // other constraints
            if (isset($col['constraint'])) {
                $res[] = join(' ', $col['constraint']);
            }

            array_walk($res, function($m) { return trim($m); });
            $result[] = join(' ', $res);
        }
        return $result;
    }

    /* utilities from UtilityTrait */
    abstract protected function quote(/*# string */ $str)/*# : string */;
}

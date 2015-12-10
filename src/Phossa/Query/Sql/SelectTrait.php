<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql;

/**
 * Implementation of SelectInterface
 *
 * @trait
 * @package \Phossa\Shared
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Sql\SelectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait SelectTrait
{
    /**
     * {@inheritDoc}
     */
    public function from(
        $table = '',
        /*# string */ $as = ''
    )/*# : SelectInterface */ {
        // array input
        if (is_array($table)) {
            foreach($table as $i => $t) {
                if (is_int($i)) {
                    $this->from($t);
                } else {
                    $this->from($i, $t);
                }
            }

        } else if (0 === func_num_args()) {
            $this->parts['tbl'] = [];

        // scalar input (convert to string)
        } else {
            if ($as) {
                $this->parts['tbl'][] = [ $table, $as ];
            } else {
                $this->parts['tbl'][] = $table;
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function field(
        $field = '',
        /*# string */ $as = ''
    )/*# : SelectInterface */ {
        //array input
        if (is_array($field)) {
            foreach($field as $i => $f) {
                if (is_int($i)) {
                    $this->field($f);
                } else {
                    $this->field($i, $f);
                }
            }

        // reset fields
        } else if (0 === func_num_args()) {
            $this->parts['fld'] = [];

        // string input
        } else {
            if ($as) {
                $this->parts['fld'][] = [ $field, $as ];
            } else {
                $this->parts['fld'][] = $field;
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function distinct()/*# : SelectInterface */
    {
        $this->parts['distinct'] = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function into(
        /*# string */ $tblSpec
    )/*# : SelectInterface */ {
        $this->parts['into'] = $tblSpec;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function union()/*# : SelectInterface */
    {
        // remember previous parts
        $prev = $this->parts;

        // reset current parts
        $this->parts = [];
        $this->parts['union'] = true;
        $this->parts['prev']  = $prev;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : SelectInterface */
    {
        // remember previous parts
        $prev = $this->parts;

        // reset current parts
        $this->parts = [];
        $this->parts['unionall'] = true;
        $this->parts['prev']     = $prev;

        return $this;
    }
}

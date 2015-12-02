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

use Phossa\Query\Exception;
use Phossa\Query\Message\Message;

/**
 * SELECT query
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\QueryAbstract
 * @see     \Phossa\Query\Sql\SelectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SelectQuery extends \Phossa\Query\QueryAbstract implements
    SelectInterface
{
    /**
     * {@inheritDoc}
     */
    public function from(
        $table,
        /*# string */ $as = ''
    )/*# : SelectQueryInterface */ {
        // array input
        if (is_array($table)) {
            foreach($table as $i => $t) {
                if (is_int($i)) {
                    $this->from($t);
                } else {
                    $this->from($i, $t);
                }
            }

        // string input
        } else if (is_string($table)) {
            if ($as) {
                $this->parts['tbl'][] = [ $table, $as ];
            } else {
                $this->parts['tbl'][] = $table;
            }

        // wrong input
        } else {
            throw new Exception\InvalidArgumentException(
                Message::get(Message::INVALID_TBL_SPEC, gettype($table)),
                Message::INVALID_TBL_SPEC
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function field(
        $field,
        /*# string */ $as = ''
    )/*# : SelectQueryInterface */ {
        //array input
        if (is_array($field)) {
            foreach($field as $i => $f) {
                if (is_int($i)) {
                    $this->field($f);
                } else {
                    $this->field($i, $f);
                }
            }

        // string input
        } else if (is_string($field)) {
            if ($as) {
                $this->parts['fld'][] = [ $field, $as ];
            } else {
                $this->parts['fld'][] = $field;
            }

        // wrong input
        } else {
            throw new Exception\InvalidArgumentException(
                Message::get(Message::INVALID_COL_SPEC, gettype($field)),
                Message::INVALID_COL_SPEC
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function distinct()/*# : SelectQueryInterface */
    {
        $this->parts['distinct'] = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function into(
        /*# string */ $tblSpec
    )/*# : SelectQueryInterface */ {

    }

    /**
     * {@inheritDoc}
     */
    public function union()/*# : SelectQueryInterface */
    {

    }

    /**
     * {@inheritDoc}
     */
    public function unionAll()/*# : SelectQueryInterface */
    {

    }

    /**
     * {@inheritDoc}
     */
    public function before(
        /*# : string */ $location,
        /*# : string */ $string
    )/*# : SelectQueryInterface */ {

    }

    /**
     * {@inheritDoc}
     */
    public function after(
        /*# : string */ $location,
        /*# : string */ $string
    )/*# : SelectQueryInterface */ {

    }

    /**
     * {@inheritDoc}
     */
    public function options(
        $options
    )/*# : SelectQueryInterface */
    {

    }
}

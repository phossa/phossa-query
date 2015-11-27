<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Select;

use Phossa\Query;
use Phossa\Query\Message\Message;

/**
 * SELECT query
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Query\Select\SelectQueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SelectQuery implements SelectQueryInterface
{
    use Query\QueryTrait;

    /**
     * query parts
     *
     * @var    array
     * @type   array
     * @access protected
     */
    protected $parts = [];

    /**
     * Previous select query object, used by union()
     *
     * @var    SelectQueryInterface
     * @type   SelectQueryInterface
     * @access protected
     */
    protected $previous;

    /**
     * {@inheritDoc}
     */
    public function getStatement(
        Driver\DriverInterface $driver = null
    )/*# : string */ {
        // get driver
        if ($driver === null) $driver = $this->getDriver();

    }

    /**
     * {@inheritDoc}
     */
    public function select()/*# : SelectQueryInterface */
    {
        if (func_num_args()) {
            return call_user_func_array([$this, 'column'], func_get_args());
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function from(
        $tblSpec
    )/*# : SelectQueryInterface */ {
        if (($t = $this->isTblSpec($tblSpec))) {
            $this->parts[] = ['from', $tblSpec];
        } else {
            $this->debug(Message::INVALID_TBL_SPEC, $tblSpec);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function fromAs($table, $as)/*# : SelectQueryInterface */
    {
        if (($t = $this->isTblSpec($table))) {
            $this->parts[] = ['from', $table, $as];
        } else {
            $this->debug(Message::INVALID_TBL_SPEC, $table);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function column(
        $colSpec
    )/*# : SelectQueryInterface */ {
        if (($t = $this->isColSpec($colSpec))) {
            $this->parts[] = is_string($t) ? ['col', $t] : ['col', $t[0], $t[1]];
        } else {
            $this->debug(Message::INVALID_COL_SPEC, $colSpec);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function columnAs(
        $colSpec,
        $as
    )/*# : SelectQueryInterface */ {

    }

    /**
     * {@inheritDoc}
     */
    public function distinct()/*# : SelectQueryInterface */
    {

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

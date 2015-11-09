<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * SQL query builder
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class QueryBuilder implements QueryBuilderInterface
{
    /**
     * The query object
     *
     * @var    QueryInterface
     * @access protected
     */
    protected $query;

    /**
     * Driver
     *
     * @var    Driver\DriverInterface
     * @access protected
     */
    protected $driver;

    /**
     * {@inheritDoc}
     */
    public function select()/*# : SelectQueryInterface */
    {
        // get driver if previously set(or set in $query)
        // otherwise use the default driver
        $driver = $this->getDriver();

        // create the SELECT query
        $this->query = new Select\SelectQuery($this);

        // set query's driver
        $this->query->setDriver($driver);

        // set columns
        return call_user_func_array(
            [ $this->query, 'column' ],
            func_get_args()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDriver(Driver\DriverInterface $driver)
    {
        // if $query set, set $query's driver
        if ($this->query) $this->query->setDriver($driver);

        // set driver for $this
        $this->driver = $driver;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDriver()/*# : Driver\DriverInterface */
    {
        // if $query set, use $query's driver
        if ($this->query) return $this->query->getDriver();

        // if $this driver not set, use a new Mysql driver
        return $this->driver ?: new Driver\Mysql();
    }

    /**
     * {@inheritDoc}
     */
    public function toSql(
        Driver\DriverInterface $driver = null
    )/*# : string */ {
        // if $driver provided
        if ($driver) $this->setDriver($driver);

        // return string
        return $this->__toString();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# string */
    {
        // if $query set
        if ($this->query) return $this->query->__toString();

        // otherwise return empty string
        return '';
    }
}

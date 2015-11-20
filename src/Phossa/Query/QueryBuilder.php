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
     * Current query object
     *
     * @var    QueryInterface
     * @access protected
     */
    protected $query;

    /**
     * Query object pool
     *
     * @var    QueryInterface[]
     * @access protected
     */
    protected $pool = [];

    /**
     * Driver
     *
     * @var    Driver\DriverInterface
     * @access protected
     */
    protected $driver;

    /**
     * Constructor
     *
     * @param  Driver\DriverInterface $driver (optional) db driver
     * @access public
     */
    public function __construct(
        Driver\DriverInterface $driver = null
    ) {
        if ($driver) $this->setDriver($driver);
    }

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

        // multiple query objects supported
        $this->pool[] = $this->query;

        // set query's driver
        $this->query->setDriver($driver);

        // set columns
        return call_user_func_array(
            [ $this->query, 'select' ],
            func_get_args()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDriver(Driver\DriverInterface $driver)
    {
        // set query objects driver
        if ($this->pool) {
            foreach($this->pool as $q) {
                $q->setDriver($driver);
            }
        }

        // set driver for $this
        $this->driver = $driver;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDriver()/*# : Driver\DriverInterface */
    {
        return $this->driver ?:
            ($this->query ? $this->query->getDriver() : new Driver\Mysql());
    }

    /**
     * {@inheritDoc}
     */
    public function toSql(
        Driver\DriverInterface $driver = null
    )/*# : string */ {
        if ($this->query) return $this->query->toSql($driver);
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# string */
    {
        return $this->toSql();
    }
}

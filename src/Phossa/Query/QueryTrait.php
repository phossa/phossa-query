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

use Phossa\Query\Driver;

/**
 * QueryTrait
 *
 * Partial implementation of QueryInterface for those *QueryInterface
 *
 * @trait
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Query\QueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait QueryTrait
{
    /**
     * query build object
     *
     * @var    QueryBuilderInterface
     * @access protected
     */
    protected $builder;

    /**
     * Driver
     *
     * @var    Driver\DriverInterface
     * @access protected
     */
    protected $driver;

    /**
     * constructor
     *
     * @param  QueryBuilderInterface $builder the builder object
     * @access public
     * @api
     */
    public function __construct(QueryBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * {@inheritDoc}
     */
    public function setDriver(Driver\DriverInterface $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDriver()/*# : Driver\DriverInterface */
    {
        return $this->driver ?: new Driver\Mysql();
    }

    /**
     * {@inheritDoc}
     */
    public function toSql(
        Driver\DriverInterface $driver = null
    )/*# : string */ {
        if ($driver) $this->setDriver($driver);
        return $this->__toString();
    }
}

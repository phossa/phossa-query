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
 * Abstract class of *Query
 *
 * @abstract
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\QueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
abstract class QueryAbstract implements QueryInterface
{
    /**
     * query builder object
     *
     * @var    QueryBuilderInterface
     * @access protected
     */
    protected $builder;

    /**
     * query parts
     *
     * @var    array
     * @type   array
     * @access protected
     */
    protected $parts = [];

    /**
     * constructor
     *
     * @param  QueryBuilderInterface $builder the builder object
     * @access public
     * @api
     */
    public function __construct(
        QueryBuilderInterface $builder
    ) {
        $this->builder = $builder;
    }

    /**
     * {@inheritDoc}
     */
    public function getQueryParts()
    {
        return $this->parts;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(
        Dialect\DialectInterface $dialect = null,
        /*# string */ $tablePrefix = ''
    )/*# : string */ {
        // get table prefix
        if ($tablePrefix === '') {
            $tablePrefix = $this->builder->getTablePrefix();
        }

        // get dialect
        if ($dialect === null) {
            $dialect = $this->builder->getDialect();
        }

        return $dialect->buildSql($this, $tablePrefix);
    }

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# array */
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# string */
    {
        return $this->getStatement();
    }
}

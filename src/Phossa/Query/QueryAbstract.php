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
     * @access protected
     */
    protected $parts    = [];

    /**
     * query options
     *
     * @var    array
     * @access protected
     */
    protected $options  = [];

    /**
     * constructor
     *
     * @param  QueryBuilderInterface $builder the builder object
     * @param  array $options (optional) query related options
     * @access public
     * @api
     */
    public function __construct(
        QueryBuilderInterface $builder,
        array $options = []
    ) {
        $this->builder = $builder;
        $this->options = $options;
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
        array $settings = [],
        Dialect\DialectInterface $dialect = null
    )/*# : string */ {
        // get dialect
        if ($dialect === null) {
            $dialect = $this->builder->getDialect();
        }

        // build sql
        return $dialect->buildSql(
            $this,
            array_replace(
                $this->builder->getConfigs(), // builder configs
                $settings // extra output settings
            )
        );
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

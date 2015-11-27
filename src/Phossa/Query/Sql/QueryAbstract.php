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

use Phossa\Query\Message\Message;

/**
 * Abstract class of Query
 *
 * @abstract
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Sql\QueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
abstract class QueryAbstract implements QueryInterface
{
    /**
     * query build object
     *
     * @var    QueryBuilderInterface
     * @access protected
     */
    protected $builder;

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

    /**
     * Is this a column spec ?
     *
     * @param  string $colSpec column spec to check
     * @return false|string|array
     * @access protected
     */
    protected function isColSpec(/*# string */ $colSpec)
    {
        // column <= 64 chars, alias <= 256 chars
        $pattern = '\s*(.{1,64})(\s+AS\s+(.{1,256})\s*)?$';

        if (preg_match("/$pattern/i", $colSpec, $m)) {
            $col = $m[1];
            $as  = isset($m[3]) ? $m[3] : false;
            return $as ? $col : [$col, $as];
        }
        return false;
    }

    /**
     * Is this a table spec ?
     *
     * @param  string $tblSpec table spec
     * @return false|string|array
     * @access protected
     */
    protected function isTblSpec(/*# string */ $tblSpec)
    {
        return $tblSpec;
    }

    /**
     * debug message
     *
     * @param  int $code message code
     * @return this
     * @access protected
     */
    protected function debug()
    {
        $mesg = Message::get($code, func_get_args());
    }
}

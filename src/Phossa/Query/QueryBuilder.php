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
    use \Psr\Log\LoggerAwareTrait;

    // <editor-fold defaultstate="collapsed" desc="properties">

    /**
     * Current query object
     *
     * @var    OutputInterface
     * @access protected
     */
    protected $query;

    /**
     * Dialect
     *
     * @var    Dialect\DialectInterface
     * @access protected
     */
    protected $dialect;

    /**
     * Table prefix
     *
     * @var    string
     * @access protected
     */
    protected $prefix = '';

    /**
     * Query mode, strict or loose
     *
     * @var    int
     * @access protected
     */
    protected $mode = 0;

    /**#@+
     * Query mode constant bits
     *
     * @const
     */

    /**
     * Spitting warning about non-standard sql features in the statement
     */
    const MODE_NONCOMPAT    = 1;

    /**#@-*/

    // </editor-fold>

    /**
     * Constructor
     *
     * If no dialect specified, only COMMON type of query returned
     * default is loose mode for different queries
     *
     * @param  Dialect\DialectInterface $dialect (optional) sql dialect
     * @param  string $prefix table prefix if any
     * @param  int $mode sql mode
     * @access public
     */
    public function __construct(
        Dialect\DialectInterface $dialect = null,
        /*# string */ $prefix = '',
        /*# int */ $mode = 0
    ) {
        // set dialect
        if ($dialect) $this->setDialect($dialect);

        // set table prefix
        if ($prefix) $this->setTablePrefix($prefix);

        // set mode
        if ($mode) $this->setQueryMode($mode);
    }

    // <editor-fold defaultstate="collapsed" desc="BuilderOptionInterface">

    /**
     * {@inheritDoc}
     */
    public function setQueryMode(
        /*# int */ $mode
    )/*# : BuilderOptionInterface */ {
        $this->mode = (int) $mode;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getQueryMode()/*# : int */
    {
        return $this->mode;
    }

    /**
     * {@inheritDoc}
     */
    public function setDialect(
        Dialect\DialectInterface $dialect
    )/*# : DialectCapableInterface */ {
        $this->dialect = $dialect;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDialect()/*# : Dialect\DialectInterface */
    {
        if ($this->dialect === null) {
            $this->dialect = new Dialect\Common();
        }
        return $this->dialect;
    }

    /**
     * {@inheritDoc}
     */
    public function setTablePrefix(
        /*# string */ $prefix
    )/*# : BuilderOptionInterface */ {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTablePrefix()/*# : string */
    {
        return $this->prefix;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="BuilderLoggerInterface">

    /**
     * {@inheritDoc}
     */
    public function warning(
        /*# string */ $message,
        array $context = []
    ) {
        if ($this->logger) $this->logger->warning($message, $context);
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="QueryInterface">

    /**
     * {@inheritDoc}
     */
    public function getStatement(
        Dialect\DialectInterface $dialect = null,
        /*# string */ $tablePrefix = ''
    )/*# : string */ {
        if ($this->query) {
            return $this->query->getStatement(
                $dialect ?: $this->getDialect(),
                $tablePrefix ?: $this->getTablePrefix()
            );
        }
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */ {
        if ($this->query) return $this->query->getBindings();
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# string */
    {
        return $this->getStatement();
    }

    // </editor-fold>

    /**
     * {@inheritDoc}
     */
    public function select()/*# : SelectQueryInterface */
    {
        $this->query = new Sql\SelectQuery($this);
        return $this->query;
    }
}

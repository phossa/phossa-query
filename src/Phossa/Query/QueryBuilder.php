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

use Phossa\Query\Exception;
use Phossa\Query\Message\Message;

/**
 * SQL query builder
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\QueryBuilderInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class QueryBuilder implements QueryBuilderInterface
{
    // Implementation of ConfigInterface & LoggerInterface
    use LoggerTrait, ConfigTrait;

    /**
     * Spitting warning about non-standard sql features in the statement
     * @const
     */
    const MODE_NONCOMPAT    = 1;

    /**
     * Current query object
     *
     * @var    QueryInterface
     * @access protected
     */
    protected $query;

    /**
     * Constructor
     *
     * @param  array $configs (optional) builder configs
     * @param  Dialect\DialectInterface $dialect (optional) insert dialect
     * @param  int $mode sql mode
     * @access public
     */
    public function __construct(
        array $configs = [],
        Dialect\DialectInterface $dialect = null
    ) {
        // set dialect
        if ($dialect) $this->setDialect($dialect);

        // set configs
        if ($configs) $this->setConfigs($configs);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(
        array $settings = [],
        Dialect\DialectInterface $dialect = null
    )/*# : string */ {
        if ($this->query) {
            return $this->query->getStatement(
                $settings,
                $dialect ?: $this->getDialect()
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

    /**
     * {@inheritDoc}
     */
    public function select(
        array $options = []
    )/*# : Sql\SelectQueryInterface */ {
        // different select class
        if (isset($options['className'])) {
            $class = (string) $options['className'];
            if (is_a(
                $class,
                '\Phossa\Query\Sql\SelectInterface',
                true)
            ) {
                $this->query = new $class($this, $options);
            } else {
                throw new Exception\LogicException(
                    Message::get(Message::INVALID_SELECT_CLASS, $class),
                    Message::INVALID_SELECT_CLASS
                );
            }
        } else {
            $this->query = new Sql\SelectQuery($this, $options);
        }
        return $this->query;
    }
}

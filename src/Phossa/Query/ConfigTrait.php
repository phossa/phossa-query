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
 * Implementation of ConfigInterface
 *
 * @trait
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @seee    \Phossa\Query\ConfigInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ConfigTrait
{
    /**
     * Dialect
     *
     * @var    \Phossa\Query\Dialect\DialectInterface
     * @access protected
     */
    protected $dialect;

    /**
     * Builder configs
     *
     * @var    array
     * @access protected
     */
    protected $configs = [
        // query builder mode
        'queryMode'     => 0,

        // table name prefix
        'tablePrefix'   => '',

        // quote identifier
        'autoQuote'     => true,

        // dialect class name
        'dialectClass'  => '\Phossa\Query\Dialect\Mysql',
    ];

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
            $class = $this->configs['dialectClass'];
            if (is_a(
                $class,
                '\Phossa\Query\Dialect\DialectInterface',
                true)
            ) {
                $this->dialect = new $class();
            } else {
                throw new Exception\LogicException(
                    Message::get(Message::INVALID_DIALECT_CLASS, $class),
                    Message::INVALID_DIALECT_CLASS
                );
            }
        }
        return $this->dialect;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfigs(
        array $configs
    )/*# : BuilderConfigInterface */ {
        $this->configs = array_replace($this->configs, $configs);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigs() {
        return $this->configs;
    }
}

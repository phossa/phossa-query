<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Package
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Statement;

use Phossa\Query\SettingsTrait;
use Phossa\Query\BuilderInterface;
use Phossa\Query\Dialect\DialectInterface;

/**
 * StatementAbstract
 *
 * @abstract
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
abstract class StatementAbstract implements StatementInterface
{
    use SettingsTrait;

    /**
     * builder object
     *
     * @var    BuilderInterface
     * @access protected
     */
    protected $builder;

    /**
     * clause parts
     *
     * @var    array
     * @access protected
     */
    protected $clauses = [];

    /**
     * Binding values
     *
     * @var    array
     * @access protected
     */
    protected $bindings = [];

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * {@inheritDoc}
     */
    public function getSql(
        array $settings = [],
        DialectInterface $dialect = null
    )/*# : string */ {

        // update settings
        array_replace(
            $this->settings,
            $this->builder->getSettings(),
            $settings
        );

        // set dialect
        $dialect ?: $this->builder->getDialect();

        // @todo
    }

    /**
     * {@inheritDoc}
     */
    public function getBindings()/*# : array */
    {
        return $this->bindings;
    }

    /**
     * {@inheritDoc}
     */
    public function getClauses()/*# : array */
    {
        return $this->clauses;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getSql();
    }
}

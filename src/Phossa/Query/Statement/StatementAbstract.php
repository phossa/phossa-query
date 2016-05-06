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
use Phossa\Query\Dialect\DialectAwareTrait;

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
    use SettingsTrait, DialectAwareTrait, BuilderAwareTrait, PreviousTrait,
        ParameterTrait, UtilityTrait;

    /**
     * clause parts
     *
     * @var    array
     * @access protected
     */
    protected $clauses = [];

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function getSql(
        array $settings = [],
        DialectInterface $dialect = null,
        /*# bool */ $replace = true
    )/*# : string */ {
        // update dialect
        $this->setDialect($dialect ?: $this->builder->getDialect());

        // update settings
        $this->combineSettings(array_replace(
            $this->builder->getSettings(), $settings
        ));

        // build previous statement if any
        $res = [];
        if ($this->hasPrevious()) {
            $res[] = $this->getPrevious()->getSql(
                $this->getSettings(), $this->getDialect(), false
            );
        }

        // build current statement
        $res[] = $this->build();
        $sql   = join($this->getSettings()['seperator'], $res);

        // replace those placeholders
        if ($replace) {
            $sql = $this->rebindParam(
                $sql,
                $this->getSettings()['positionedParam']
            );
        }

        return $sql;
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

    /**
     * Build the statement
     *
     * @return string
     * @access protected
     */
    abstract protected function build()/*# : string */;
}

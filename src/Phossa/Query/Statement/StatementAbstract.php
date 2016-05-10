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

use Phossa\Query\Builder\SettingsTrait;
use Phossa\Query\Clause\BeforeAfterTrait;
use Phossa\Query\Builder\BuilderInterface;
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
    use UtilityTrait,
        SettingsTrait,
        PreviousTrait,
        BeforeAfterTrait,
        DialectAwareTrait,
        BuilderAwareTrait,
        ParameterAwareTrait;

    /**
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [];

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->setBuilder($builder);
        $this->setDialect($builder->getDialect());
    }

    /**
     * {@inheritDoc}
     */
    public function getSql(
        array $settings = [],
        /*# bool */ $replace = true
    )/*# : string */ {
        // merge with builder's & provided settings
        $this->combineSettings(
            array_replace($this->getBuilder()->getSettings(), $settings)
        );

        // current settings
        $currSettings = $this->getSettings();

        // build PREVIOUS statement if any (UNION etc)
        $res = [];
        if ($this->hasPrevious()) {
            $res[] = $this->getPrevious()->getSql($currSettings, false);
        }

        // build current statement
        $res[] = $this->build();

        // raw sql with placeholders
        $sql = join($currSettings['seperator'], $res);

        // replace placeholders with '?' or values
        if ($replace) {
            // flush bindings array
            $this->resetBindings();

            // replace with '?' or values
            $sql = $this->bindValues($sql, $currSettings['positionedParam'],
                $currSettings['escapeFunction']);
        }

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function getType()/*# : string */
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()/*# : string */
    {
        return $this->getSql();
    }

    /**
     * Real building the statement
     *
     * @return string
     * @access protected
     */
    protected function build()/*# : string */
    {
        // settings
        $settings = $this->getSettings();

        // configs
        $configs  = $this->getConfig();

        // start of result array
        $result = [$this->type];

        // seperator & indent
        $sp = $settings['seperator'];
        $in = $settings['indent'];
        $si = $sp . $in;

        foreach ($configs as $pos => $part) {
            // before clause
            if (isset($this->before[$pos])) {
                $result[] = join($sp, $this->before[$pos]);
            }

            $built = call_user_func([$this, $part['func']]);
            if (!empty($built)) {
                $prefix = $part['prefix'] . (empty($part['prefix']) ?
                    ($part['indent'] ? $in : '') : $si);
                $result[] = $prefix . join($part['join'] . $si, $built);
            }

            // after clause
            if (isset($this->after[$pos])) {
                $result[] = join($sp, $this->after[$pos]);
            }
        }

        return join($sp, $result);
    }

    /**
     * Get config of this type of statement
     *
     * @return array
     * @access protected
     */
    protected function getConfig()/*# : array */
    {
        return $this->config;
    }
}

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
    use \Phossa\Query\SettingsTrait;

    /**
     * builder object
     *
     * @var    BuilderInterface
     * @access protected
     */
    protected $builder;

    /**
     * Constructor
     *
     * @param  BuilderInterface $builder
     * @param  array $settings
     * @access public
     */
    public function __construct(
        BuilderInterface $builder,
        array $settings = []
    ) {
        $this->setSettings($settings)->builder = $builder;
    }

    /**
     * @inheritDoc
     */
    public function getStatement(
        array $settings = [],
        DialectInterface $dialect = null
    )/*# : string */ {
        array_replace(
            $this->builder->getSettings(),
            $this->settings,
            $settings
        );
        $dialect ?: $this->builder->getDialect();
    }

    /**
     * @inheritDoc
     */
    public function __toString()/*# : string */
    {
        return $this->getStatement();
    }
}

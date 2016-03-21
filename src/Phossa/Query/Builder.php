<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * Builder
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     BuilderInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Builder implements BuilderInterface
{
    use SettingsTrait,
        Dialect\DialectAwareTrait;

    /**
     * tables
     *
     * @var    array
     * @access protected
     */
    protected $tables = [];

    /**
     * Constructor
     *
     * @param  array $settings builder settings
     * @param  Dialect\DialectInterface $dialect
     * @access public
     */
    public function __construct(
        array $settings = [],
        Dialect\DialectInterface $dialect = null
    ) {
        $this->setSettings($settings)->setDialect($dialect);
    }

    /**
     * @inheritDoc
     */
    public function table($tables)
    {
        $this->tables = is_array($tables) ? $tables : [ $tables ];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function select()/*# : Statement\SelectInterface */
    {
        // SELECT statement
        $select = new Statement\Select($this);

        // set from
        if (count($this->tables)) {
            $select->from($this->tables);
        }

        return $select;
    }
}

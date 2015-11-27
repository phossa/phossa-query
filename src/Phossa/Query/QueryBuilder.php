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
    /**
     * Current query object
     *
     * @var    QueryInterface
     * @access protected
     */
    protected $query;

    /**
     * Query object pool
     *
     * @var    QueryInterface[]
     * @access protected
     */
    protected $pool = [];

    /**
     * Driver
     *
     * @var    Driver\DriverInterface
     * @access protected
     */
    protected $driver;

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
     * strict mode, warns non-strict usage, such as 'user AS u'
     */
    const MODE_STRICT       = 1;

    /**
     * warns about non-standard sql features in the statement such as
     * SELECT HIGH_PRIORITY ...
     */
    const MODE_NONCOMPAT    = 2;

    /**#@-*/

    /**
     * Constructor
     *
     * If no driver specified, only COMMON type of query returned
     * default is loose mode for different queries
     *
     * @param  Driver\DriverInterface $driver (optional) db driver
     * @param  int $mode sql mode
     * @access public
     */
    public function __construct(
        Driver\DriverInterface $driver = null,
        /*# string */ $prefix = '',
        /*# int */ $mode = 0
    ) {
        // set driver
        if ($driver) $this->setDriver($driver);

        // set table prefix
        $this->setTablePrefix($prefix);

        // set mode
        if ($mode) $this->mode = (int) $mode;
    }

    /**
     * {@inheritDoc}
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * {@inheritDoc}
     */
    public function select()/*# : SelectQueryInterface */
    {
        // get driver if set before or use the Common driver
        $driver = $this->getDriver();

        // create the SELECT query
        $this->query  = new Select\SelectQuery($this, $driver);

        // multiple query objects supported for UNION select etc.
        $this->pool[] = $this->query;

        // set columns
        return call_user_func_array(
            [ $this->query, 'select' ],
            func_get_args()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setDriver(Driver\DriverInterface $driver)
    {
        // set query objects' driver
        if ($this->pool) {
            foreach($this->pool as $q) {
                $q->setDriver($driver);
            }
        }

        // set driver for $this
        $this->driver = $driver;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDriver()/*# : Driver\DriverInterface */
    {
        return $this->driver ?: new Driver\Common();
    }

    /**
     * {@inheritDoc}
     */
    public function setTablePrefix(/*# string */ $prefix
    )/*# : QueryInterface */ {
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

    /**
     * {@inheritDoc}
     */
    public function getStatement(
        Driver\DriverInterface $driver = null,
        /*# string */ $tablePrefix = ''
    )/*# : string */ {
        if ($this->query) {
            return $this->query->getStatement(
                $driver,
                $tablePrefix ?: $this->prefix
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
}

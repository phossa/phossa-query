<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql\Select;

/**
 * Schema related interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SchemaInterface
{
    /**
     * Set default database schema
     *
     * @param  string $dbName db schema name
     * @return this
     * @access public
     * @api
     */
    public function setDb(
        /*# string */ $dbName
    )/*# : SelectQueryInterface */;

    /**
     * Set database name prefix
     *
     * @param  string $dbPrefix db name prefix
     * @return this
     * @access public
     * @api
     */
    public function setDbPrefix(
        /*# string */ $dbPrefix
    )/*# : SelectQueryInterface */;

    /**
     * Set table name prefix
     *
     * @param  string $tblPrefix table name prefix
     * @return this
     * @access public
     * @api
     */
    public function setTblPrefix(
        /*# string */ $tblPrefix
    )/*# : SelectQueryInterface */;

    /**
     * Set column name prefix
     *
     * @param  string $colPrefix column name prefix
     * @return this
     * @access public
     * @api
     */
    public function setColPrefix(
        /*# string */ $colPrefix
    )/*# : SelectQueryInterface */;
}

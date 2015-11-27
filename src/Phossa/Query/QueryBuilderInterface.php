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
 * QueryBuilder interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Sql\QueryInterface
 * @see     \Phossa\Query\BuilderOptionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryBuilderInterface extends
    Sql\QueryInterface,
    BuilderOptionInterface
{
    /**
     * Select query
     *
     * @param  string|array variable parameters
     * @return Sql\Select\SelectQuery
     * @see    Sql\Select\SelectInterface::select()
     * @access public
     * @api
     */
    public function select()/*# : Sql\Select\SelectQuery */;
}

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
 * @see     \Phossa\Query\OutputInterface
 * @see     \Phossa\Query\ConfigInterface
 * @see     \Phossa\Query\LoggerInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryBuilderInterface extends
    OutputInterface,
    ConfigInterface,
    LoggerInterface
{
    /**
     * SELECT query
     *
     * @param  array $options select query related options
     * @return Sql\SelectQueryInterface
     * @throws \Phossa\Query\Exception\LogicException
     *         if $options['className'] not a valid selectQuery class
     * @access public
     * @api
     */
    public function select(
        array $options = []
    )/*# : Sql\SelectQueryInterface */;
}

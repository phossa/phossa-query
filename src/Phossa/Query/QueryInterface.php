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
 * QueryInterface
 *
 * Base for the *QueryInterface and QueryBuilderInterface, provides the
 * ability of setting up driver and printing out the sql
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Query\ToStringInterface
 * @see     Phossa\Query\Driver\DriverCapableInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface QueryInterface extends
    ToStringInterface,
    Driver\DriverCapableInterface
{

}

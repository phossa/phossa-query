<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Sql;

/**
 * Select query interface
 *
 * @interface
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\QueryInterface
 * @see     \Phossa\Query\Sql\SelectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SelectQueryInterface extends
    \Phossa\Query\QueryInterface,
    SelectInterface
{

}

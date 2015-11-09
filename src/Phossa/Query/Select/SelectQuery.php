<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Select;

use Phossa\Query;

/**
 * SELECT query
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Query\Select\SelectQueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SelectQuery implements SelectQueryInterface
{
    use Query\QueryTrait;
}

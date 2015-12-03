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
 * SELECT query
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\QueryAbstract
 * @see     \Phossa\Query\Sql\SelectQueryInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SelectQuery extends \Phossa\Query\QueryAbstract implements
    SelectQueryInterface
{
    use SelectTrait;
}

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

namespace Phossa\Query\Dialect\Common;

use Phossa\Query\Statement\StatementInterface;
use Phossa\Query\Clause\ColInterface;
use Phossa\Query\Clause\FromInterface;
use Phossa\Query\Clause\JoinInterface;
use Phossa\Query\Clause\WhereInterface;
use Phossa\Query\Clause\LimitInterface;
use Phossa\Query\Clause\UnionInterface;
use Phossa\Query\Clause\AliasInterface;
use Phossa\Query\Clause\HavingInterface;
use Phossa\Query\Clause\GroupByInterface;
use Phossa\Query\Clause\OrderByInterface;
use Phossa\Query\Clause\FunctionInterface;

/**
 * SelectStatementInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SelectStatementInterface extends StatementInterface, AliasInterface, ColInterface, FromInterface, FunctionInterface, GroupByInterface, HavingInterface, JoinInterface, LimitInterface, OrderByInterface, UnionInterface, WhereInterface
{
}

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
use Phossa\Query\Statement\Clause\ColInterface;
use Phossa\Query\Statement\Clause\FromInterface;
use Phossa\Query\Statement\Clause\JoinInterface;
use Phossa\Query\Statement\Clause\WhereInterface;
use Phossa\Query\Statement\Clause\LimitInterface;
use Phossa\Query\Statement\Clause\UnionInterface;
use Phossa\Query\Statement\Clause\AliasInterface;
use Phossa\Query\Statement\Clause\HavingInterface;
use Phossa\Query\Statement\Clause\GroupByInterface;
use Phossa\Query\Statement\Clause\OrderByInterface;
use Phossa\Query\Statement\Clause\FunctionInterface;
use Phossa\Query\Statement\Clause\BeforeAfterInterface;

/**
 * SelectInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SelectInterface extends StatementInterface, AliasInterface, BeforeAfterInterface, ColInterface, FromInterface, FunctionInterface, GroupByInterface, HavingInterface, JoinInterface, LimitInterface, OrderByInterface, UnionInterface, WhereInterface
{
}

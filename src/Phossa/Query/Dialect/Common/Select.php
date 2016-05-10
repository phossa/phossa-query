<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Package
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Dialect\Common;

use Phossa\Query\Clause\FromTrait;
use Phossa\Query\Clause\JoinTrait;
use Phossa\Query\Clause\LimitTrait;
use Phossa\Query\Clause\UnionTrait;
use Phossa\Query\Clause\WhereTrait;
use Phossa\Query\Clause\AliasTrait;
use Phossa\Query\Clause\HavingTrait;
use Phossa\Query\Clause\GroupByTrait;
use Phossa\Query\Clause\OrderByTrait;
use Phossa\Query\Clause\FunctionTrait;
use Phossa\Query\Statement\StatementAbstract;

/**
 * Select
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     SelectStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Select extends StatementAbstract implements SelectStatementInterface
{
    use FromTrait, FunctionTrait, GroupByTrait, HavingTrait, JoinTrait,
        LimitTrait, OrderByTrait, UnionTrait, WhereTrait, AliasTrait;

    /**
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type = 'SELECT';

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_DISTINCT    = 10;
    const ORDER_COLUMN      = 20;
    const ORDER_FROM        = 30;
    const ORDER_JOIN        = 40;
    const ORDER_WHERE       = 50;
    const ORDER_GROUPBY     = 60;
    const ORDER_HAVING      = 70;
    const ORDER_ORDERBY     = 80;
    const ORDER_LIMIT       = 90;
    const ORDER_UNION       = 1000;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // distinct
        self::ORDER_DISTINCT  => [
            'prefix'    => '',
            'func'      => 'buildDistinct',
            'join'      => '',
            'indent'    => false,
        ],

        // columns
        self::ORDER_COLUMN => [
            'prefix'    => '',
            'func'      => 'buildCol',
            'join'      => ',',
            'indent'    => true, // hornor indent settings
        ],
        // from
        self::ORDER_FROM => [
            'prefix'    => 'FROM',
            'func'      => 'buildFrom',
            'join'      => ',',
            'indent'    => false,
        ],
        // join
        self::ORDER_JOIN => [
            'prefix'    => '',
            'func'      => 'buildJoin',
            'join'      => '',
            'indent'    => true,
        ],
        // where
        self::ORDER_WHERE => [
            'prefix'    => 'WHERE',
            'func'      => 'buildWhere',
            'join'      => '',
            'indent'    => false,
        ],
        // group by
        self::ORDER_GROUPBY => [
            'prefix'    => 'GROUP BY',
            'func'      => 'buildGroupBy',
            'join'      => ',',
            'indent'    => false,
        ],
        // having
        self::ORDER_HAVING => [
            'prefix'    => 'HAVING',
            'func'      => 'buildHaving',
            'join'      => '',
            'indent'    => false,
        ],
        // order by
        self::ORDER_ORDERBY => [
            'prefix'    => 'ORDER BY',
            'func'      => 'buildOrderBy',
            'join'      => ',',
            'indent'    => false,
        ],
        // limit
        self::ORDER_LIMIT => [
            'prefix'    => '',
            'func'      => 'buildLimit',
            'join'      => '',
            'indent'    => false,
        ],
        // union
        self::ORDER_UNION => [
            'prefix'    => '',
            'func'      => 'buildUnion',
            'join'      => '',
            'indent'    => false,
        ],
    ];
}

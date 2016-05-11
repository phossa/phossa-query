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

namespace Phossa\Query\Dialect\Mysql;

use Phossa\Query\Clause\LimitTrait;
use Phossa\Query\Clause\OrderByTrait;
use Phossa\Query\Clause\HintTrait;
use Phossa\Query\Clause\LimitInterface;
use Phossa\Query\Clause\OrderByInterface;
use Phossa\Query\Clause\HintInterface;
use Phossa\Query\Dialect\Common\Update as CommonUpdate;

/**
 * Mysql Update
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Update
 * @see     MysqlInterface
 * @see     HintInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Update extends CommonUpdate implements MysqlInterface, HintInterface, OrderByInterface, LimitInterface
{
    use HintTrait, OrderByTrait, LimitTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLHINT = 5;
    const ORDER_ORDBY     = 40;
    const ORDER_LIMIT     = 50;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $dialect_config = [
        // hints
        self::ORDER_MYSQLHINT  => [
            'prefix'    => '',
            'func'      => 'buildHint',
            'join'      => ' ',
            'indent'    => true,
        ],

        // order by
        self::ORDER_ORDBY => [
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
    ];
}

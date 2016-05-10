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
use Phossa\Query\Clause\MysqlFlagTrait;
use Phossa\Query\Clause\PartitionTrait;
use Phossa\Query\Clause\LimitInterface;
use Phossa\Query\Clause\OrderByInterface;
use Phossa\Query\Clause\MysqlFlagInterface;
use Phossa\Query\Clause\PartitionInterface;
use Phossa\Query\Dialect\Common\Delete as CommonDelete;

/**
 * Mysql Delete
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Delete
 * @see     MysqlInterface
 * @see     MysqlFlagInterface
 * @see     PartitionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Delete extends CommonDelete implements MysqlInterface, MysqlFlagInterface, PartitionInterface, OrderByInterface, LimitInterface
{
    use MysqlFlagTrait, PartitionTrait, OrderByTrait, LimitTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLFLAG = 5;
    const ORDER_PARTITION = 15;
    const ORDER_ORDBY     = 40;
    const ORDER_LIMIT     = 50;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $dialect_config = [
        // flags
        self::ORDER_MYSQLFLAG  => [
            'prefix'    => '',
            'func'      => 'buildFlag',
            'join'      => ' ',
            'indent'    => true,
        ],

        // partition
        self::ORDER_PARTITION => [
            'prefix'    => '',
            'func'      => 'buildPartition',
            'join'      => '',
            'indent'    => false,
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

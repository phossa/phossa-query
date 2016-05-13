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

use Phossa\Query\Clause\JoinTrait;
use Phossa\Query\Clause\HintTrait;
use Phossa\Query\Clause\HintInterface;
use Phossa\Query\Clause\JoinInterface;
use Phossa\Query\Clause\PartitionTrait;
use Phossa\Query\Clause\DeleteRecordTrait;
use Phossa\Query\Clause\PartitionInterface;
use Phossa\Query\Clause\DeleteRecordInterface;
use Phossa\Query\Dialect\Common\Delete as CommonDelete;

/**
 * Mysql Delete
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Delete
 * @see     MysqlInterface
 * @see     HintInterface
 * @see     PartitionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Delete extends CommonDelete implements MysqlInterface, HintInterface, DeleteRecordInterface, PartitionInterface, JoinInterface
{
    use HintTrait, DeleteRecordTrait, PartitionTrait, JoinTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLHINT = 5;
    const ORDER_RECORD    = 8;
    const ORDER_JOIN      = 15;
    const ORDER_PARTITION = 20;

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

        // table records to delete
        self::ORDER_RECORD  => [
            'prefix'    => '',
            'func'      => 'buildRecord',
            'join'      => ',',
            'indent'    => true,
        ],

        // join
        self::ORDER_JOIN => [
            'prefix'    => '',
            'func'      => 'buildJoin',
            'join'      => '',
            'indent'    => true,
        ],

        // partition
        self::ORDER_PARTITION => [
            'prefix'    => '',
            'func'      => 'buildPartition',
            'join'      => '',
            'indent'    => false,
        ],
    ];
}

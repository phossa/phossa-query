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

use Phossa\Query\Clause\OnDupTrait;
use Phossa\Query\Clause\MysqlFlagTrait;
use Phossa\Query\Clause\PartitionTrait;
use Phossa\Query\Dialect\Common\Insert as CommonInsert;

/**
 * Mysql Insert
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Insert
 * @see     InsertStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Insert extends CommonInsert implements InsertStatementInterface
{
    use MysqlFlagTrait, PartitionTrait, MysqlTrait, OnDupTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLFLAG = 5;
    const ORDER_PARTITION = 15;
    const ORDER_ONDUP     = 100;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $my_config = [
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

        // on dup
        self::ORDER_ONDUP => [
            'prefix'    => 'ON DUPLICATE KEY UPDATE',
            'func'      => 'buildOnDup',
            'join'      => ',',
            'indent'    => true,
        ],
    ];
}

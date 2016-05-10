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

use Phossa\Query\Clause\MysqlFlagTrait;
use Phossa\Query\Clause\ForUpdateTrait;
use Phossa\Query\Clause\PartitionTrait;
use Phossa\Query\Clause\PartitionInterface;
use Phossa\Query\Clause\ForUpdateInterface;
use Phossa\Query\Dialect\Common\Select as CommonSelect;

/**
 * Mysql Select
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Select
 * @see     SelectStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Select extends CommonSelect implements ForUpdateInterface, MysqlInterface, PartitionInterface
{
    use MysqlFlagTrait, ForUpdateTrait, PartitionTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLFLAG = 15;
    const ORDER_PARTITION = 45;
    const ORDER_FORUPDATE = 300;

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

        // for update
        self::ORDER_FORUPDATE  => [
            'prefix'    => '',
            'func'      => 'buildForUpdate',
            'join'      => '',
            'indent'    => false,
        ],
    ];
}

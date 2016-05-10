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
use Phossa\Query\Clause\MysqlFlagInterface;
use Phossa\Query\Dialect\Common\Update as CommonUpdate;

/**
 * Mysql Update
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Update
 * @see     MysqlInterface
 * @see     MysqlFlagInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Update extends CommonUpdate implements MysqlInterface, MysqlFlagInterface
{
    use MysqlFlagTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_MYSQLFLAG = 5;

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
    ];
}

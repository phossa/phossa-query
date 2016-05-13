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

use Phossa\Query\Clause\SetTrait;
use Phossa\Query\Clause\FromTrait;
use Phossa\Query\Clause\WhereTrait;
use Phossa\Query\Statement\StatementAbstract;

/**
 * Update
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     UpdateStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Update extends StatementAbstract implements UpdateStatementInterface
{
    use FromTrait, SetTrait, WhereTrait;

    /**
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type = 'UPDATE';

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_FROM  = 10;
    const ORDER_SET   = 20;
    const ORDER_WHERE = 30;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // table
        self::ORDER_FROM => [
            'prefix'    => '',
            'func'      => 'buildFrom',
            'join'      => ', ',
            'indent'    => true,
        ],

        // set cols
        self::ORDER_SET => [
            'prefix'    => 'SET',
            'func'      => 'buildSet',
            'join'      => ',',
            'indent'    => true,
        ],

        // where
        self::ORDER_WHERE => [
            'prefix'    => 'WHERE',
            'func'      => 'buildWhere',
            'join'      => '',
            'indent'    => false,
        ],
    ];
}

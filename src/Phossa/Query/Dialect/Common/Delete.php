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

use Phossa\Query\Clause\FromTrait;
use Phossa\Query\Clause\WhereTrait;
use Phossa\Query\Statement\StatementAbstract;

/**
 * Delete
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DeleteStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Delete extends StatementAbstract implements DeleteStatementInterface
{
    use FromTrait, WhereTrait;

    /**
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type = 'DELETE';

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_TABLE = 10;
    const ORDER_WHERE = 30;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // table
        self::ORDER_TABLE => [
            'prefix'    => '',
            'func'      => 'buildFrom',
            'join'      => ', ',
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

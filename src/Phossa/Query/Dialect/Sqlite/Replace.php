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

namespace Phossa\Query\Dialect\Sqlite;

/**
 * Mysql Replace
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Insert
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Replace extends Insert implements ReplaceStatementInterace
{
    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_HINT = 100;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $dialect_config = [
        // hints
        self::ORDER_HINT  => [
            'prefix'    => '',
            'func'      => 'replaceHint',
            'join'      => ' ',
            'indent'    => false,
        ],
    ];

    /**
     * Replace hint
     *
     * @return array
     * @access protected
     */
    protected function replaceHint()/*# : array */
    {
        return ['ON CONFLICT REPLACE'];
    }
}

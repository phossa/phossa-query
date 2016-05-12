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
use Phossa\Query\Clause\IntoTrait;
use Phossa\Query\Clause\ValueTrait;
use Phossa\Query\Statement\StatementAbstract;

/**
 * Insert
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     InsertStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Insert extends StatementAbstract implements InsertStatementInterface
{
    use IntoTrait, SetTrait, ValueTrait;

    /**
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type = 'INSERT';

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_INTO   = 10;
    const ORDER_SET    = 20;
    const ORDER_VALUES = 25;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // into
        self::ORDER_INTO  => [
            'prefix'    => '',
            'func'      => 'buildInto',
            'join'      => '',
            'indent'    => false,
        ],

        // set cols
        self::ORDER_SET => [
            'prefix'    => '',
            'func'      => 'buildSet',
            'join'      => '',
            'indent'    => true,
        ],

        // build values
        self::ORDER_VALUES => [
            'prefix'    => 'VALUES',
            'func'      => 'buildValues',
            'join'      => '',
            'indent'    => true,
        ],
    ];

    /**
     * INSERT ... SELECT
     *
     * {@inheritDoc}
     */
    public function select(
        $col = '',
        /*# string */ $colAlias = ''
    )/*# : SelectStatementInterface */ {
        return $this->getBuilder()->setPrevious($this)->select($col, $colAlias);
    }
}

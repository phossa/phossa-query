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

namespace Phossa\Query\Dialect\Pgsql;

use Phossa\Query\Clause\ReturningTrait as RTrait;

/**
 * ReturnTrait
 *
 * @package package_name
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Clause\ReturningTrait
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ReturnTrait
{
    use RTrait;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_RETURNING = 100;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $dialect_config = [
        // partition
        self::ORDER_RETURNING => [
            'prefix'    => 'RETURNING',
            'func'      => 'buildReturning',
            'join'      => ', ',
            'indent'    => true,
        ],
    ];
}

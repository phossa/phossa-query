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
     * Statement type
     *
     * @var    string
     * @access protected
     */
    protected $type = 'REPLACE';
}

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

namespace Phossa\Query\Dialect\Mssql;

use Phossa\Query\Dialect\Common\Select as CommonSelect;

/**
 * MSSQL Select
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\Dialect\Common\Select
 * @see     MssqlInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Select extends CommonSelect implements MssqlInterface
{
}

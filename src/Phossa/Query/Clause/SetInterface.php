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

namespace Phossa\Query\Clause;

use Phossa\Query\Clause\WhereInterface;

/**
 * SetInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface SetInterface
{
    /**
     * Insert into table
     *
     * @param  string|array $col
     * @param  mixed value scalar or Select query
     * @return self
     * @access public
     */
    public function set($col, $value = WhereInterface::NO_VALUE);
}

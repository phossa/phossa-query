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

/**
 * TableConstraintInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ClauseInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface TableConstraintInterface extends ClauseInterface
{
    /**
     * Create a primary key with cols
     *
     * @param  array $colNames
     * @param  string $extraClause appended after
     * @return self
     * @access public
     */
    public function primaryKey(array $colNames, /*# string */ $extraClause = '');

    /**
     * Create an unique key with cols
     *
     * @param  array $colNames
     * @param  string $extraClause appended after
     * @return self
     * @access public
     */
    public function uniqueKey(array $colNames, /*# string */ $extraClause = '');

    /**
     * Create a constraint
     *
     * @param  string $string
     * @return self
     * @access public
     */
    public function constraint(/*# string */ $string);
}

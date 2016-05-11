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
 * ColDefinitionInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface ColDefinitionInterface extends ClauseInterface
{
    /**
     * Add one column
     *
     * $colType: 'FLOAT(10, 3) UNSIGNED ZEROFILL'
     *
     * @param  string $colName
     * @param  string $colType 'INT' etc.
     * @return self
     * @access public
     */
    public function addCol(
        /*# string */ $colName,
        /*# string */ $colType
    );

    /**
     * Previous column is not null
     *
     * @param  string $conflictClause
     * @return self
     * @access public
     */
    public function notNull(/*# string */ $conflictClause = '');

    /**
     * Previous column default value
     *
     * @param  mixed $value
     * @param  bool $raw raw value
     * @return self
     * @access public
     */
    public function defaultValue($value, /*# bool */ $raw = false);

    /**
     * AUTO_INCREMENT
     *
     * @return self
     * @access public
     */
    public function autoIncrement();

    /**
     * PRIMARY KEY
     *
     * @param  string $conflictClause
     * @return self
     * @access public
     */
    public function primary(/*# string */ $conflictClause = '');

    /**
     * UNIQUE KEY
     *
     * @param  string $conflictClause
     * @return self
     * @access public
     */
    public function unique(/*# string */ $conflictClause = '');

    /**
     * Other column constraints in raw string
     *
     * @param  string $string
     * @return self
     * @access public
     */
    public function colConstraint(/*# string */ $string);
}

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
 * OnInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface OnInterface extends ClauseInterface
{
    /**
     * ON
     *
     * @param  string $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @param  bool $or
     * @return self
     * @access public
     */
    public function on(
        /*# string */ $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE,
        /*# bool */ $or = false
    );

    /**
     * OR ON
     *
     * @param  string $firstTableCol
     * @param  string $operator
     * @param  string $secondTableCol
     * @return self
     * @access public
     */
    public function orOn(
        /*# string */ $firstTableCol,
        /*# string */ $operator = ClauseInterface::NO_OPERATOR,
        /*# string */ $secondTableCol = ClauseInterface::NO_VALUE
    );

    /**
     * Raw mode ON
     *
     * @param  string $on
     * @return self
     * @access public
     */
    public function onRaw(/*# string */ $on);

    /**
     * Raw mode OR ON
     *
     * @param  string $on
     * @return self
     * @access public
     */
    public function orOnRaw(/*# string */ $on);
}

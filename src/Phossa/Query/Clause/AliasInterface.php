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
 * AliasInterface
 *
 * Indicating AS for a subquery etc.
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface AliasInterface extends ClauseInterface
{
    /**
     * @param  string $alias
     * @return self
     * @access public
     */
    public function alias(/*# string */ $alias);

    /**
     * has alias or not
     *
     * @return bool
     * @access public
     */
    public function hasAlias()/*#: bool */;

    /**
     * get alias
     *
     * @return string
     * @access public
     */
    public function getAlias()/*#: string */;
}

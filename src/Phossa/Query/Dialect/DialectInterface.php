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

namespace Phossa\Query\Dialect;

use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\Common\SelectStatementInterface;
use Phossa\Query\Dialect\Common\InsertStatementInterface;
use Phossa\Query\Dialect\Common\UpdateStatementInterface;
use Phossa\Query\Dialect\Common\DeleteStatementInterface;

/**
 * DialectInterface
 *
 * @interface
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DialectInterface
{
    /**#@+
     * quote options for different clause part
     *
     * @const
     */

    /**
     * quote nothing
     */
    const QUOTE_NO    = 0;

    /**
     * quote, but string with spaces are not quoted
     */
    const QUOTE_YES   = 1;

    /**
     * quote string with spaces also
     */
    const QUOTE_SPACE = 2;

    /**#@-*/

    /**
     * SELECT statement
     *
     * @param  BuilderInterface $builder
     * @return SelectStatementInterface
     * @access public
     */
    public function select(BuilderInterface $builder)/*# : SelectStatementInterface */;

    /**
     * INSERT statement
     *
     * @param  BuilderInterface $builder
     * @return InsertStatementInterface
     * @access public
     */
    public function insert(BuilderInterface $builder)/*# : InsertStatementInterface */;

    /**
     * UPDATE statement
     *
     * @param  BuilderInterface $builder
     * @return UpdateStatementInterface
     * @access public
     */
    public function update(BuilderInterface $builder)/*# : UpdateStatementInterface */;

    /**
     * DELETE statement
     *
     * @param  BuilderInterface $builder
     * @return DeleteStatementInterface
     * @access public
     */
    public function delete(BuilderInterface $builder)/*# : DeleteStatementInterface */;

    /**
     * Quote identifer
     *
     * - col        => "col"
     * - tbl.col    => "tbl"."col"
     *
     * @param  string $string string to be quoted
     * @param  bool $quote quote or not
     * @return string
     * @access public
     */
    public function quote(
        /*# string */ $string,
        /*# bool */ $quote = DialectInterface::QUOTE_YES
    )/*# : string */;

    /**
     * Get dialect specific data type representation
     *
     * @param string $typeName
     * @param int|array $attributes
     * @return string
     */
    public function getType(
        /*# string */ $typeName,
        $attributes = 0
    )/*# : string */;
}

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

use Phossa\Query\Dialect\Mysql\Select;
use Phossa\Query\Dialect\Mysql\Insert;
use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\Mysql\SelectStatementInterface;
use Phossa\Query\Dialect\Mysql\InsertStatementInterface;

/**
 * Mysql dialect
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Common
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Mysql extends Common
{
    /**
     * quote prefix
     *
     * @var    string
     * @access protected
     */
    protected $quote_prefix = '`';

    /**
     * quote suffix
     *
     * @var    string
     * @access protected
     */
    protected $quote_suffix = '`';

    /**
     * {@inheritDoc}
     */
    public function select(BuilderInterface $builder)/*# : SelectStatementInterface */
    {
        return new Select($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function insert(BuilderInterface $builder)/*# : InsertStatementInterface */
    {
        return new Insert($builder);
    }
}

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

use Phossa\Query\Dialect\Mssql\Select;
use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\Common\SelectStatementInterface;

/**
 * MSSQL dialect
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     Common
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Mssql extends Common
{
    /**
     * quote prefix
     *
     * @var    string
     * @access protected
     */
    protected $quote_prefix = '[';

    /**
     * quote suffix
     *
     * @var    string
     * @access protected
     */
    protected $quote_suffix = ']';

    /**
     * {@inheritDoc}
     */
    public function select(BuilderInterface $builder)/*# : SelectStatementInterface */
    {
        return new Select($builder);
    }
}

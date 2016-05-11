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

namespace Phossa\Query\Dialect\Common;

use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Statement\BuilderAwareTrait;

/**
 * Create
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     CreateInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Create implements CreateInterface
{
    use BuilderAwareTrait;

    /**
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function table(
        /*# string */ $tableName
    )/*# : CreateTableStatementInterface */ {
        $class = get_class($this) . 'Table';
        return new $class($tableName, $this->getBuilder());
    }
}

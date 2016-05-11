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

use Phossa\Query\Statement\BuilderAwareInterface;

/**
 * CreateInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface CreateInterface extends BuilderAwareInterface
{
    /**
     * create table
     *
     * @param  string $tableName
     * @return CreateTableStatementInterface
     * @access public
     */
    public function table(
        /*# string */ $tableName
    )/*# : CreateTableStatementInterface */;
}

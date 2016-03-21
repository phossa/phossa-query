<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Package
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Statement;

use Phossa\Query\Statement\Clause\FromTrait;

/**
 * SelectStatement
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     SelectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Select extends StatementAbstract implements SelectInterface
{
    use FromTrait;
}

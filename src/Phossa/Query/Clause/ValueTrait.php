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

use Phossa\Query\Statement\RawInterface;
use Phossa\Query\Statement\StatementInterface;

/**
 * ValueTrait
 *
 * Dealing with value of WHERE, SET etc.
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ValueTrait
{
    /**
     * Process value
     *
     * @param  mixed $value
     * @return string placeholder or value
     * @access protected
     */
    protected function processValue($value)/*# : string */
    {
        // object
        if (is_object($value)) {
            if ($value instanceof RawInterface) {
                return $value->getStatement([], false);
            } elseif ($value instanceof StatementInterface) {
                return '(' . $value->getStatement([], false) . ')';
            }
        }

        // scalar
        if (is_null($value)) {
            return 'NULL';
        } else {
            return $this->getPlaceholder($value);
        }
    }

    /* from ParameterAwareTrait */
    abstract protected function getPlaceholder($value)/*# : string */;
}

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

namespace Phossa\Query\Statement\Clause;

/**
 * FromTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     FromInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait FromTrait
{
    /**
     * @inheritDocs
     */
    public function from($table, /*# string */ $as = '')
    {
        if (is_array($table)) {
            $this->clause['from'] = $table;
        } else {
            if (empty($as)) {
                $this->clause['from'][] = (string) $table;
            } else {
                $this->clause['from'][(string) $table] = (string) $as;
            }
        }
        return $this;
    }
}

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
 * FieldTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     FieldInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait FieldTrait
{
    /**
     * {@inheritDoc}
     */
    public function distinct()
    {
        $this->clauses['distinct'] = true;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function field($field, /*# string */ $fieldAlias = '')
    {
        if (is_array($field)) {
            foreach ($field as $key => $val) {
                if (is_numeric($key)) {
                    $this->clauses['field'][$val] = true;
                } else {
                    $this->clauses['field'][$key] = $val;
                }
            }
        } else {
            $this->clauses['field'][(string) $field] =
                '' === $fieldAlias ? true : (string) $fieldAlias;
        }
        return $this;
    }
}

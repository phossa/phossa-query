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
 * ForUpdateTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ForUpdateInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait ForUpdateTrait
{
    /**
     * FOR UPDATE
     *
     * @var    bool
     * @access protected
     */
    protected $clause_forupdate = false;

    /**
     * Generic FOR UPDATE
     *
     * @return self
     * @access public
     */
    public function forUpdate()
    {
        $this->clause_forupdate = true;
        return $this;
    }

    /**
     * Build FOR UPDATE
     *
     * @return array
     * @access protected
     */
    protected function buildForUpdate()/*# : array */
    {
        $result = [];
        if ($this->clause_forupdate) {
            $result[] = 'FOR UPDATE';
        }
        return $result;
    }
}

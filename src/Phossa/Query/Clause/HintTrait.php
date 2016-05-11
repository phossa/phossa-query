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
 * HintTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     HintInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait HintTrait
{
    /**
     * hints
     *
     * @var    array
     * @access protected
     */
    protected $clause_hints = [];

    /**
     * {@inheritDoc}
     */
    public function addHint(/*# string */ $hintName)
    {
        $this->clause_hints[strtoupper($hintName)] = true;
        return $this;
    }

    /**
     * Build HINT
     *
     * @return array
     * @access protected
     */
    protected function buildHint()/*# : array */
    {
        $res = [];
        foreach ($this->clause_hints as $name => $status) {
            if ($status) {
                $res[] = $name;
            }
        }
        if (!empty($res)) {
            return [join(' ', $res)];
        } else {
            return [];
        }
    }
}

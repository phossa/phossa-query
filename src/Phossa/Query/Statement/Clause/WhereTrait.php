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
 * WhereTrait
 *
 * @trait
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     WhereInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait WhereTrait
{
    use ClauseTrait;

    /**
     * parameters
     *
     * @var    array
     * @access protected
     */
    protected $params = [];

    /**
     * @inheritDoc
     */
    public function where($field)
    {
        $args  = func_get_args();
        $count = count($args);

        // where logic
        $logic = $args[$count - 1] === WhereInterface::LOGIC_OR ?
            WhereInterface::LOGIC_OR : WhereInterface::LOGIC_AND;

        if (is_array($args[0])) {
            foreach ($args[0] as $fld => $val) {

            }
        } else {
            $this->clauses['where'][] = [
                $logic,
                (string) $field,
                isset($args[2]) ? strtoupper($args[2]) : '=',
            ];
            $this->clauses['param'][] = $args[1];
        }
    }

    /**
     * @inheritDoc
     */
    public function orWhere()
    {
        $args = func_get_args();
        array_push($args, WhereInterface::LOGIC_OR);
        return call_user_func_array([$this, 'where'], $args);
    }
}

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

namespace Phossa\Query\Statement;

use Phossa\Query\Clause\OnTrait;
use Phossa\Query\Clause\WhereTrait;

/**
 * Statement part for WHERE/ON etc.
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExpressionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Expression extends StatementAbstract implements ExpressionInterface
{
    use WhereTrait, OnTrait;

    /**
     * configs
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // on
        'on' => [
            'prefix'    => '',
            'func'      => 'buildOn',
            'join'      => ' ',
        ],
        // where
        'where' => [
            'prefix'    => '',
            'func'      => 'buildWhere',
            'join'      => ' ',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function build()/*# : string */
    {
        $result = [];

        foreach ($this->getConfig() as $part) {
            $built = call_user_func([$this, $part['func']]);
            if (!empty($built)) {
                $result[] =
                    $part['prefix'] . (empty($part['prefix']) ? '' : ' ') .
                    join($part['join'], $built);
            }
        }
        return '(' . join($this->settings['seperator'], $result) . ')';
    }
}

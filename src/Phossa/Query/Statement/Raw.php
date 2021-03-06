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

use Phossa\Query\Builder\BuilderInterface;

/**
 * Pass as raw string
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     RawInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Raw extends StatementAbstract implements RawInterface
{
    /**
     * raw string
     *
     * @var    string
     * @access protected
     */
    protected $str = '';

    /**
     * Constructor
     *
     * @param  string $rawSql
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(
        /*# string */ $rawSql,
        BuilderInterface $builder
    ) {
        parent::__construct($builder);
        $this->str = (string) $rawSql;
    }

    /**
     * {@inheritDoc}
     */
    protected function build()/*# : string */
    {
        return $this->str;
    }
}

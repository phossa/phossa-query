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
 * AliasTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     AliasInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait AliasTrait
{
    /**
     * subquery alias
     *
     * @var    string
     * @access protected
     */
    protected $alias;

    /**
     * {@inheritDoc}
     */
    public function alias(/*# string */ $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAlias()/*#: bool */
    {
        return null !== $this->alias;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()/*#: string */
    {
        // auto generate a random one
        if (!$this->hasAlias()) {
            $this->alias = substr(md5(microtime(true)),0,3);
        }
        return $this->alias;
    }
}

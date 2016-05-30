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

namespace Phossa\Query\Builder;

use Phossa\Query\Statement\ExecutorInterface;

/**
 * ExecutorAwareTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     ExecutorAwareInterface
 * @version 1.0.3
 * @since   1.0.3 added
 */
trait ExecutorAwareTrait
{
    /**
     * the query executor
     *
     * @var    ExecutorInterface
     * @access protected
     */
    protected $executor;

    /**
     * {@inheritDoc}
     */
    public function setExecutor(ExecutorInterface $executor)
    {
        $this->executor = $executor;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getExecutor()
    {
        return $this->executor;
    }
}

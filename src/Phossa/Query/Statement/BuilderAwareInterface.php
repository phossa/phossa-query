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

use Phossa\Query\BuilderInterface;

/**
 * BuilderAwareInterface
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface BuilderAwareInterface
{
    /**
     * Set the builder
     *
     * @param  BuilderInterface $builder
     * @return this;
     * @access public
     */
    public function setBuilder(BuilderInterface $builder);

    /**
     * Return the builder
     *
     * @return BuilderInterface
     * @access public
     */
    public function getBuilder()/*# : BuilderInterface */;
}

<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query;

/**
 * Implementation of LoggerInterface
 *
 * @trait
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Query\LoggerInterface
 * @see     \Psr\Log\LoggerAwareTrait
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait LoggerTrait
{
    use \Psr\Log\LoggerAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function warning(
        /*# string */ $message,
        array $context = []
    ) {
        if ($this->logger) $this->logger->warning($message, $context);
    }
}

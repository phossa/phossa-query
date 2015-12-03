<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Message;

use Phossa\Shared\Message\MessageAbstract;

/**
 * Message class for Phossa\Query
 *
 * @package \Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Message extends MessageAbstract
{
    /**#@+
     * @var   int
     */

    /**
     * Invalid table spec "%s"
     */
    const INVALID_TBL_SPEC      = 1511091322;

    /**
     * Invalid field spec "%s"
     */
    const INVALID_FLD_SPEC      = 1511091323;

    /**
     * Invalid SELECT query class "%s" found
     */
    const INVALID_SELECT_CLASS  = 1511091324;

    /**
     * Invalid dialect class "%s" found
     */
    const INVALID_DIALECT_CLASS = 1511091325;
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected static $messages = [
        self::INVALID_TBL_SPEC      => 'Invalid table spec "%s"',
        self::INVALID_FLD_SPEC      => 'Invalid field spec "%s"',
        self::INVALID_SELECT_CLASS  => 'Invalid SELECT query class "%s" found',
        self::INVALID_DIALECT_CLASS => 'Invalid dialect class "%s" found',
    ];
}

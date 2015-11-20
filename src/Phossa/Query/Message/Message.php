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
     * Invalid column spec "%s"
     */
    const INVALID_COL_SPEC      = 1511091323;

    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected static $messages = [
        self::INVALID_TBL_SPEC      => 'Invalid table spec "%s"',
        self::INVALID_COL_SPEC      => 'Invalid column spec "%s"',
    ];
}

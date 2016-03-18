<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Package
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Message;

use Phossa\Shared\Message\MessageAbstract;

/**
 * Message class for Phossa\Query
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Shared\Message\MessageAbstract
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Message extends MessageAbstract
{
    /**#@+
     * @var   int
     */

    /**
     * Query "%s" duplicated for method "%s"
     */
    const ROUTE_DUPLICATED      = 1603111803;

    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected static $messages = [
    ];
}

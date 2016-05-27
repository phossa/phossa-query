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

namespace Phossa\Query\Dialect;

use Phossa\Shared\Pattern\StaticAbstract;

/**
 * DataType
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class DataType extends StaticAbstract
{
    const INTEGER       = 'INTEGER';
    const TINYINT       = 'TINYINT';
    const SMALLINT      = 'SMALLINT';
    const MEDIUMINT     = 'MEDIUMINT';
    const BIGINT        = 'BIGINT';

    const DECIMAL       = 'DECIMAL';
    const REAL          = 'REAL';
    const FLOAT         = 'FLOAT';
    const DOUBLE        = 'DOUBLE';
    const NUMERIC       = 'NUMERIC';

    const CHAR          = 'CHAR';
    const VARCHAR       = 'VARCHAR';
    const BINARY        = 'BINARY';
    const VARBINARY     = 'VARBINARY';

    const BLOB          = 'BLOB';
    const TINYBLOB      = 'TINYBLOB';
    const MEDIUMBLOB    = 'MEDIUMBLOB';
    const LONGBLOB      = 'LONGBLOB';

    const TEXT          = 'TEXT';
    const TINYTEXT      = 'TINYTEXT';
    const MEDIUMTEXT    = 'MEDIUMTEXT';
    const LONGTEXT      = 'LONGTEXT';

    const ENUM          = 'ENUM';
    const SET           = 'SET';
    const CLOB          = 'CLOB';

    const BIT           = 'INTEGER';
    const BOOLEAN       = 'TINYINT';

    const PHP_OBJECT    = 'BLOB';
    const PHP_ARRAY     = 'BLOB';
    const JSON          = 'JSON';

    const DATE          = 'DATE';
    const TIME          = 'TIME';
    const DATETIME      = 'DATETIME';
    const TIMESTAMP     = 'TIMESTAMP';
    const UNIXTIME      = 'INTEGER';

    const GEOMETRY      = 'GEOMETRY';

    /**
     * Return current class
     *
     * @return string
     */
    public static function getClass()/*# : string */
    {
        return __CLASS__;
    }
}

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

namespace Phossa\Query\Dialect\Common;

use Phossa\Query\Clause\CreateTableTrait;
use Phossa\Query\Clause\TableOptionTrait;
use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Statement\StatementAbstract;
use Phossa\Query\Clause\TableConstraintTrait;

/**
 * CreateTable
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     StatementAbstract
 * @see     CreateTableStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class CreateTable extends StatementAbstract implements CreateTableStatementInterface
{
    use TableConstraintTrait, TableOptionTrait, CreateTableTrait;

    /**
     * table name
     *
     * @var    string
     * @access protected
     */
    protected $tbl_name;

    /**
     * clauses ordering
     *
     * @var    int
     * @access protected
     */
    const ORDER_TBLCONST = 20;
    const ORDER_TBLOPT   = 30;
    const ORDER_LIKE     = 40;

    /**
     * order, prefix, join char
     *
     * @var    array
     * @access protected
     */
    protected $config = [
        // table constraint
        self::ORDER_TBLCONST => [
            'prefix'    => '(',
            'func'      => 'buildTblConst',
            'join'      => ',',
            'indent'    => true,
        ],

        // table option
        self::ORDER_TBLOPT => [
            'prefix'    => ')',
            'func'      => 'buildTblOpt',
            'join'      => ',',
            'indent'    => false,
        ],

        // like another table
        self::ORDER_LIKE => [
            'prefix'    => '',
            'func'      => 'buildLike',
            'join'      => '',
            'indent'    => false,
        ],
    ];

    /**
     * Constructor
     *
     * @param  string $tableName
     * @param  BuilderInterface $builder
     * @access public
     */
    public function __construct(
        /*# string */ $tableName,
        BuilderInterface $builder
    ) {
        parent::__construct($builder);
        $this->tbl_name = $tableName;
    }

    /**
     * Things to do before build
     *
     * @access protected
     */
    protected function beforeBuild()
    {
        $this->type = 'CREATE';
        if ($this->temporary) {
            $this->type .= ' TEMPORARY';
        }
        $this->type .= ' TABLE';

        if ($this->if_not_exists) {
            $this->type .= ' IF NOT EXISTS';
        }

        $this->type .= ' ' . $this->quote($this->tbl_name);

        return;
    }
}

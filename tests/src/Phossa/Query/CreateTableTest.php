<?php
namespace Phossa\Query;

use Phossa\Query\Builder;

/**
 * CreateTable test case.
 */
class CreateTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * builder object
     *
     * @var    Builder
     * @access protected
     */
    protected $builder;

    /**
     * beautiful settings
     *
     * @var    array
     * @access protected
     */
    protected $settings = [
        'seperator'     => "\n",
        'indent'        => "    ",
    ];

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->builder = new Builder();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->builder = null;
        parent::tearDown();
    }

    /**
     * create table
     *
     * @covers Phossa\Query\Dialect\Common::create()
     */
    public function testCreateTable01()
    {
        $str = <<<EOT
CREATE TEMPORARY TABLE IF NOT EXISTS "new_table"
(
    "id" INT NOT NULL AUTO_INCREMENT,
    "name" VARCHAR(20) NOT NULL DEFAULT 'NONAME' UNIQUE,
    "alias" VARCHAR(10) CHECK (),
    PRIMARY KEY ("id"),
    UNIQUE ("name"(4) ASC, "alias") ON CONFLICT REPLACE,
    UNIQUE ("id", "alias") ON CONFLICT ROLLBACK,
    FOREIGN KEY (...)
)
    DELAY_KEY_WRITE=1,
    MAX_ROWS=100
EOT;
        $crt = $this->builder->create()->table('new_table')
                    ->temp()
                    ->ifNotExists()
                    ->addCol('id', 'INT')
                        ->notNull()
                        ->autoIncrement()
                    ->addCol('name', 'VARCHAR(20)')
                        ->notNull()
                        ->unique()
                        ->defaultValue('NONAME')
                    ->addCol('alias', 'VARCHAR(10)')
                        ->colConstraint('CHECK ()')
                    ->primaryKey(['id'])
                    ->uniqueKey(['name(4) ASC', 'alias'], 'ON CONFLICT REPLACE')
                    ->uniqueKey(['id', 'alias'], 'ON CONFLICT ROLLBACK')
                    ->constraint('FOREIGN KEY (...)')
                    ->tblOption('DELAY_KEY_WRITE=1')
                    ->tblOption('MAX_ROWS=100');

        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $crt->getStatement($this->settings)
        );
    }
}

<?php
namespace Phossa\Query\Dialect;

use Phossa\Query\Builder;

/**
 * Select test case.
 */
class MysqlTest extends \PHPUnit_Framework_TestCase
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

        $this->builder = new Builder('', $this->settings, new Mysql());
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
     * multiple columns
     *
     * @covers Phossa\Query\Dialect\Mysql::select()
     */
    public function testSelect01()
    {
        $str = <<<EOT
SELECT
    `name`,
    MIN(`test_score`),
    MAX(`test_score`),
    GROUP_CONCAT(DISTINCT test_score ORDER BY test_score DESC SEPARATOR ' ')
FROM
    `students`
GROUP BY
    `name`
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->col("name")
                ->min("test_score")
                ->max("test_score")
                ->col("GROUP_CONCAT(DISTINCT test_score ORDER BY test_score DESC SEPARATOR ' ')")
                ->from("students")
                ->groupBy("name")
                ->getSql()
        );
    }

    /**
     * flags & for update
     *
     * @covers Phossa\Query\Dialect\Mysql::select()
     */
    public function testSelect02()
    {
        $str = <<<EOT
SELECT
    /*! HIGH_PRIORITY SQL_CACHE */
    `name`
FROM
    `students`
FOR UPDATE
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->col("name")
                ->from("students")
                ->addFlag('HIGH_PRIORITY')
                ->addFlag('sql_cache')
                ->forUpdate()
                ->getSql()
        );
    }
}


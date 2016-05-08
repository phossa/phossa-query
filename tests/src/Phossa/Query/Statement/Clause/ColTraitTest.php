<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * ColTrait test case.
 */
class ColTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * builder object
     *
     * @var    Builder
     * @access protected
     */
    protected $builder;

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
     * @covers Phossa\Query\Statement\Clause\ColTrait::col
     */
    public function testCol()
    {
        $this->assertEquals(
            'SELECT "user_name"',
            $this->builder->select()->col('user_name')->getSql()
        );

        $this->assertEquals(
            'SELECT "user_name" AS "n"',
            $this->builder->select()->col('user_name', 'n')->getSql()
        );

        $this->assertEquals(
            'SELECT "user_name", "user_addr"',
            $this->builder->select()->col(['user_name', 'user_addr'])->getSql()
        );

        $this->assertEquals(
            'SELECT "user_name", "user_addr" AS "a"',
            $this->builder->select()->col(['user_name', 'user_addr' => 'a'])->getSql()
        );

        // multiple col
        $this->assertEquals(
            'SELECT "user_name", "user_addr" AS "a"',
            $this->builder->select()
                ->col('user_name')
                ->col('user_addr', 'a')
                ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\ColTrait::colRaw
     */
    public function testColRaw()
    {
        $this->assertEquals(
            'SELECT user_name AS n',
            $this->builder->select()->colRaw('user_name AS n')->getSql()
        );

        $this->assertEquals(
            'SELECT COUNT(user_id) AS "cnt"',
            $this->builder->select()->colRaw('COUNT(user_id)', 'cnt')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\ColTrait::distinct
     */
    public function testDistinct()
    {
        $this->assertEquals(
            'SELECT DISTINCT "user_name"',
            $this->builder->select()->distinct()->col('user_name')->getSql()
        );

        $this->assertEquals(
            'SELECT DISTINCT "user_name" AS "n"',
            $this->builder->select()->distinct()->col('user_name', 'n')->getSql()
        );
    }
}


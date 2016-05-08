<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * GroupByTrait test case.
 */
class GroupByTraitTest extends \PHPUnit_Framework_TestCase
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
        $this->builder = (new Builder())->table('users');
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
     * @covers Phossa\Query\Statement\Clause\GroupByTrait::groupBy
     */
    public function testGroupBy()
    {
        $this->assertEquals(
            'SELECT * FROM "users" GROUP BY "age"',
            $this->builder->select()->groupBy('age')->getSql()
        );

        // multiple groupby
        $this->assertEquals(
            'SELECT * FROM "users" GROUP BY "age", "level"',
            $this->builder->select()
                ->groupBy('age')
                ->groupBy('level')
                ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\GroupByTrait::groupByRaw
     */
    public function testGroupByRaw()
    {
        $this->assertEquals(
            'SELECT * FROM "users" GROUP BY age DESC',
            $this->builder->select()->groupByRaw('age DESC')->getSql()
            );

        // multiple groupby
        $this->assertEquals(
            'SELECT * FROM "users" GROUP BY "age", level WITH ROLLUP',
            $this->builder->select()
            ->groupBy('age')
            ->groupByRaw('level WITH ROLLUP')
            ->getSql()
            );
    }
}


<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * FunctionTrait test case.
 */
class FunctionTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::func
     */
    public function testFunc()
    {
        $this->assertEquals(
            'SELECT FUNC("age")',
            $this->builder->select()->func('FUNC(%s)', 'age')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::count
     */
    public function testCount()
    {
        $this->assertEquals(
            'SELECT COUNT("age")',
            $this->builder->select()->count('age')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::min
     */
    public function testMin()
    {
        $this->assertEquals(
            'SELECT MIN("age")',
            $this->builder->select()->min('age')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::max
     */
    public function testMax()
    {
        $this->assertEquals(
            'SELECT MAX("age")',
            $this->builder->select()->max('age')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::avg
     */
    public function testAvg()
    {
        $this->assertEquals(
            'SELECT AVG("age") AS "avg"',
            $this->builder->select()->avg('age', 'avg')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::sum
     */
    public function testSum()
    {
        $this->assertEquals(
            'SELECT SUM("age") AS "s"',
            $this->builder->select()->sum('age', 's')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::sumDistinct
     */
    public function testSumDistinct()
    {
        $this->assertEquals(
            'SELECT SUM(DISTINCT "age") AS "s"',
            $this->builder->select()->sumDistinct('age', 's')->getSql()
        );
    }

    /**
     * Test function combinations
     *
     * @covers Phossa\Query\Statement\Clause\FunctionTrait::func
     */
    public function testFunc2()
    {
        $this->assertEquals(
            'SELECT COUNT("user_id") AS "cnt", MIN("age"), MAX("score")',
            $this->builder->select()
            ->count('user_id', 'cnt')
            ->min('age')
            ->max('score')
            ->getSql()
        );

        $this->assertEquals(
            'SELECT SUM(DISTINCT "age") AS "a", "score"',
            $this->builder->select()
            ->sumDistinct('age', 'a')
            ->col('score')
            ->getSql()
        );
    }
}


<?php
namespace Phossa\Query\Clause;

use Phossa\Query\Builder;

/**
 * OrderByTrait test case.
 */
class OrderByTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Clause\OrderByTrait::orderByDesc
     */
    public function testOrderByDesc()
    {
        $this->assertEquals(
            'SELECT * FROM "users" ORDER BY "age" DESC',
            $this->builder->select()->orderByDesc('age')->getStatement()
        );

        // multiple orderBy
        $this->assertEquals(
            'SELECT * FROM "users" ORDER BY "age" DESC, "level" DESC',
            $this->builder->select()
                ->orderByDesc('age')
                ->orderByDesc('level')
                ->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\OrderByTrait::orderByAsc
     */
    public function testOrderByAsc()
    {
        $this->assertEquals(
            'SELECT * FROM "users" ORDER BY "age" ASC, "level" DESC',
            $this->builder->select()
            ->orderByAsc('age')
            ->orderByDesc('level')
            ->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\OrderByTrait::orderByRaw
     */
    public function testOrderByRaw()
    {
        $this->assertEquals(
            'SELECT * FROM "users" ORDER BY age ASC, level DESC',
            $this->builder->select()
            ->orderByRaw('age ASC, level DESC')
            ->getStatement()
        );
    }
}


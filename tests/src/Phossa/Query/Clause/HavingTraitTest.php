<?php
namespace Phossa\Query\Clause;

use Phossa\Query\Builder;

/**
 * HavingTrait test case.
 */
class HavingTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Clause\HavingTrait::having
     */
    public function testHaving()
    {
        // 2 params
        $this->assertEquals(
            'SELECT * FROM "users" HAVING "age" = 10',
            $this->builder->select()->having('age', 10)->getStatement()
        );

        // 3 params
        $this->assertEquals(
            'SELECT * FROM "users" HAVING "age" > 10',
            $this->builder->select()->having('age', '>', 10)->getStatement()
        );

        // raw mode
        $this->assertEquals(
            'SELECT * FROM "users" HAVING age > 10',
            $this->builder->select()->having('age > 10')->getStatement()
        );

        // multiple having
        $this->assertEquals(
            'SELECT * FROM "users" HAVING "age" > 10 AND "level" = 15',
            $this->builder->select()
                ->having('age', '>', 10)
                ->having('level', 15)
                ->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\HavingTrait::orHaving
     */
    public function testOrHaving()
    {
        $this->assertEquals(
            'SELECT * FROM "users" HAVING "age" = 10 OR "level" > 20',
            $this->builder->select()
                ->having('age', 10)
                ->orHaving('level', '>', 20)
                ->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\HavingTrait::havingRaw
     * @covers Phossa\Query\Clause\HavingTrait::orHavingRaw
     */
    public function testHavingRaw()
    {
        $this->assertEquals(
            'SELECT * FROM "users" HAVING age = 10 OR level > 10',
            $this->builder->select()
            ->havingRaw('age = 10')
            ->orHavingRaw('level > 10')
            ->getStatement()
        );
    }
}

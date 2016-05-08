<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * UnionTrait test case.
 */
class UnionTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Statement\Clause\UnionTrait::union
     * @covers Phossa\Query\Statement\Clause\UnionTrait::unionAll
     */
    public function testUnion()
    {
        $ousers = $this->builder->table('oldusers');

        $this->assertEquals(
            'SELECT * FROM "users" UNION SELECT * FROM "oldusers"',
            $this->builder->select()
                ->union()->table('oldusers')->getSql()
        );

        // multiple union
        $this->assertEquals(
            'SELECT * FROM "users" UNION SELECT * FROM "oldusers" UNION ALL SELECT "user_id" FROM "oldusers"',
            $this->builder->select()
            ->union()
                ->select()->from('oldusers')
            ->unionAll()
                ->select('user_id')->from('oldusers')
                ->getSql()
        );
    }
}


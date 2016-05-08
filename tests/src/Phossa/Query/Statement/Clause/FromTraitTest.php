<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * FromTrait test case.
 */
class FromTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Statement\Clause\FromTrait::from
     */
    public function testFrom()
    {
        $this->assertEquals(
            'SELECT * FROM "users"',
            $this->builder->select()->from('users')->getSql()
        );

        $this->assertEquals(
            'SELECT * FROM "users" AS "u"',
            $this->builder->select()->from('users', 'u')->getSql()
        );

        $this->assertEquals(
            'SELECT * FROM "users", "items"',
            $this->builder->select()->from(['users', 'items'])->getSql()
        );

        $this->assertEquals(
            'SELECT * FROM "users" AS "u", "items" AS "i"',
            $this->builder->select()
            ->from(['users' => 'u', 'items' => 'i'])->getSql()
        );

        // multitple from
        $this->assertEquals(
            'SELECT * FROM "users" AS "u", "items" AS "i"',
            $this->builder->select()
                ->from('users', 'u')
                ->from('items', 'i')
                ->getSql()
        );

        // subquery as table
        $this->assertEquals(
            'SELECT * FROM (SELECT "1", "2", "3") AS "t1"',
            $this->builder->select()
                ->from($this->builder->select([1,2,3]), 't1')
                ->getSql()
        );
    }

    /**
     * table() is same as from()
     *
     * @covers Phossa\Query\Statement\Clause\FromTrait::table
     */
    public function testTable()
    {
        $this->assertEquals(
            'SELECT * FROM "users" AS "u", "items" AS "i"',
            $this->builder->select()
            ->table(['users' => 'u', 'items' => 'i'])->getSql()
        );
    }
}


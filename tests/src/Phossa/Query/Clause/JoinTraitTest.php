<?php
namespace Phossa\Query\Clause;

use Phossa\Query\Builder;

/**
 * JoinTrait test case.
 */
class JoinTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Clause\JoinTrait::realJoin
     */
    public function testRealJoin()
    {
        // one col
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" ON "users"."uid" = "sales"."uid"',
            $this->builder->select()->realJoin('INNER', 'sales', 'uid')->getStatement()
        );

        // 2 cols
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" ON "users"."uid" = "sales"."s_uid"',
            $this->builder->select()->realJoin('INNER', 'sales', 'uid', 's_uid')->getStatement()
        );

        // 2 cols with =
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" ON "users"."uid" = "sales"."s_uid"',
            $this->builder->select()->realJoin('INNER', 'sales', 'uid', '=', 's_uid')->getStatement()
        );

        // test table alias
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->realJoin('INNER', 'sales s', 'uid', '=', 'uid')->getStatement()
        );

        // join with subquery
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN (SELECT "uid" FROM "oldusers") AS "x" ON "users"."uid" = "x"."uid"',
            $this->builder->select()->realJoin('INNER',
                $this->builder->table('oldusers')->select('uid')->alias('x'),
                'uid'
            )->getStatement()
        );

        // multiple joins
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid" INNER JOIN "order" AS "o" ON "users"."uid" = "o"."uid"',
            $this->builder->select()
                ->realJoin('INNER', 'sales s', 'uid', '=', 'uid')
                ->realJoin('INNER', 'order o', 'uid')
                ->getStatement()
        );

        // grouped on
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" (ON "users"."uid" = "sales"."s_uid" OR "users"."uid" = "sales"."puid")',
            $this->builder->select()
                ->realJoin('INNER', 'sales',
                    $this->builder->expr()
                        ->on('users.uid', 'sales.s_uid')
                        ->orOn('users.uid', 'sales.puid')
                )->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::join
     */
    public function testJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->join('sales s', 'uid')->getStatement()
            );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::innerJoin
     */
    public function testInnerJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" INNER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->innerJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::outerJoin
     */
    public function testOuterJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" OUTER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->outerJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::leftJoin
     */
    public function testLeftJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" LEFT JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->leftJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::leftOuterJoin
     */
    public function testLeftOuterJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" LEFT OUTER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->leftOuterJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::rightJoin
     */
    public function testRightJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" RIGHT JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->rightJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::rightOuterJoin
     */
    public function testRightOuterJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" RIGHT OUTER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->rightOuterJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::fullOuterJoin
     */
    public function testFullOuterJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" FULL OUTER JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->fullOuterJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * @covers Phossa\Query\Clause\JoinTrait::crossJoin
     */
    public function testCrossJoin()
    {
        $this->assertEquals(
            'SELECT * FROM "users" CROSS JOIN "sales" AS "s" ON "users"."uid" = "s"."uid"',
            $this->builder->select()->crossJoin('sales s', 'uid')->getStatement()
        );
    }

    /**
     * raw mode
     *
     * @covers Phossa\Query\Clause\JoinTrait::crossJoin
     */
    public function testJoinRaw()
    {
        $this->assertEquals(
            'SELECT * FROM "users" CROSS JOIN sales s ON users.uid = s.uid',
            $this->builder->select()
                ->crossJoin('sales s ON users.uid = s.uid')->getStatement()
        );
    }
}


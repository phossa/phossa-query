<?php
namespace Phossa\Query\Clause;

use Phossa\Query\Builder;

/**
 * WhereTrait test case.
 */
class WhereTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Clause\WhereTrait::where
     */
    public function testWhere()
    {
        $users = $this->builder;

        // 1 param
        $this->assertEquals(
            'SELECT * FROM "users" WHERE age > 18',
            $users->select()->where('age > 18')->getSql()
        );

        // 2 params
        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18',
            $users->select()->where('age', 18)->getSql()
        );


        // 3 params
        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" < 18',
            $users->select()->where('age', '<', 18)->getSql()
        );

        // array param 1
        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18 AND "score" = 100',
            $users->select()->where(['age' => 18, 'score' => 100])->getSql()
        );

        // array param 2
        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" > 18 AND "score" >= 90',
            $users->select()
            ->where(['age' => [ '>', 18 ], 'score' => [ '>=', 90 ]])
            ->getSql()
        );

        // multiple where
        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18 AND "score" >= 90',
            $users->select()
            ->where('age', 18)
            ->where('score', '>=', 90)
            ->getSql()
        );
    }

    /**
     * test groupded where
     *
     * @covers Phossa\Query\Clause\WhereTrait::where
     */
    public function testWhere2()
    {
        $users = $this->builder;
        $b = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE ("id" = 1 OR ("id" < 20 OR "id" > 100)) OR "name" = \'Tester\'',
            $users->select()->where(
                $b->expr()->where('id', 1)->orWhere(
                    $b->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
                )
            )->orWhere('name', 'Tester')->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::andWhere
     */
    public function testAndWhere()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18 AND "score" > 90',
            $users->select()
                ->where('age', 18)
                ->andWhere('score', '>', 90)
                ->getSql()
       );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::orWhere
     */
    public function testOrWhere()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18 OR "score" > 90',
            $users->select()
            ->where('age', 18)
            ->orWhere('score', '>', 90)
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereRaw
     */
    public function testWhereRaw()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE age = 18 OR "score" > 90',
            $users->select()
            ->whereRaw('age = 18')
            ->orWhere('score', '>', 90)
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::orWhereRaw
     */
    public function testOrWhereRaw()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE age = 18 OR score > 90',
            $users->select()
            ->whereRaw('age = 18')
            ->orWhereRaw('score > 90')
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereNot
     */
    public function testWhereNot()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE NOT "age" = 18 AND NOT "score" > 90',
            $users->select()
            ->whereNot('age', 18)
            ->whereNot('score', '>', 90)
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNot
     */
    public function testOrWhereNot()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" = 18 OR NOT "score" > 90',
            $users->select()
            ->where('age', 18)
            ->orWhereNot('score', '>', 90)
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereIn
     */
    public function testWhereIn()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" IN (18,19,20)',
            $users->select()->whereIn('age', [18,19,20])->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::orWhereIn
     */
    public function testOrWhereIn()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" IN (18,19,20) OR "level" IN (1,2)',
            $users->select()
                ->whereIn('age', [18,19,20])
                ->orWhereIn('level', [1,2])
                ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereNotIn
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNotIn
     */
    public function testWhereNotIn()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" NOT IN (18,19,20) OR "level" NOT IN (1,2)',
            $users->select()
            ->whereNotIn('age', [18,19,20])
            ->orWhereNotIn('level', [1,2])
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereBetween
     */
    public function testWhereBetween()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" BETWEEN 10 AND 20',
            $users->select()->whereBetween('age', 10, 20)->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::orWhereBetween
     */
    public function testOrWhereBetween()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "score" > 90 OR "age" BETWEEN 10 AND 20',
            $users->select()
                ->where('score', '>', 90)
                ->orWhereBetween('age', 10, 20)
                ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereNotBetween
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNotBetween
     */
    public function testWhereNotBetween()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" NOT BETWEEN 10 AND 20 OR "score" NOT BETWEEN 90 AND 100',
            $users->select()
            ->whereNotBetween('age', 10, 20)
            ->orWhereNotBetween('score', 90, 100)
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereNull
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNull
     */
    public function testWhereNull()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" IS NULL OR "score" IS NULL',
            $users->select()
            ->whereNull('age')
            ->orWhereNull('score')
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereNotNull
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNotNull
     */
    public function testWhereNotNull()
    {
        $users = $this->builder;

        $this->assertEquals(
            'SELECT * FROM "users" WHERE "age" IS NOT NULL OR "score" IS NOT NULL',
            $users->select()
            ->whereNotNull('age')
            ->orWhereNotNull('score')
            ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Clause\WhereTrait::whereExists
     * @covers Phossa\Query\Clause\WhereTrait::orWhereExists
     * @covers Phossa\Query\Clause\WhereTrait::whereNotExists
     * @covers Phossa\Query\Clause\WhereTrait::orWhereNotExists
     */
    public function testWhereExists()
    {
        $users = $this->builder->select('user_id')->where('age', '>', 60);
        $sales = $this->builder->table('sales');

        // whereExists
        $this->assertEquals(
            'SELECT * FROM "sales" WHERE EXISTS (SELECT "user_id" FROM "users" WHERE "age" > 60)',
            $sales->select()
                ->whereExists($users)->getSql()
        );

        // whereNotExists
        $this->assertEquals(
            'SELECT * FROM "sales" WHERE NOT EXISTS (SELECT "user_id" FROM "users" WHERE "age" > 60)',
            $sales->select()
                ->whereNotExists($users)->getSql()
        );

        // orWhereExists
        $this->assertEquals(
            'SELECT * FROM "sales" WHERE "order_id" > 10 OR EXISTS (SELECT "user_id" FROM "users" WHERE "age" > 60)',
            $sales->select()
                ->where('order_id', '>', 10)
                ->orWhereExists($users)->getSql()
        );

        // orWhereNotExists
        $this->assertEquals(
            'SELECT * FROM "sales" WHERE "order_id" > 10 OR NOT EXISTS (SELECT "user_id" FROM "users" WHERE "age" > 60)',
            $sales->select()
            ->where('order_id', '>', 10)
            ->orWhereNotExists($users)->getSql()
        );
    }
}


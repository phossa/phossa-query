<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * LimitTrait test case.
 */
class LimitTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Statement\Clause\LimitTrait::limit
     */
    public function testLimit()
    {
        // limit only
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 10',
            $this->builder->select()->limit(10)->getSql()
        );

        // wit offset
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 10 OFFSET 20',
            $this->builder->select()->limit(10, 20)->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\LimitTrait::offset
     */
    public function testOffset()
    {
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 10 OFFSET 20',
            $this->builder->select()->limit(10)->offset(20)->getSql()
        );

        // overwrite with offset
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 10 OFFSET 30',
            $this->builder->select()->offset(30)->limit(10, 20)->getSql()
        );

        // only offset
        $this->assertEquals(
            'SELECT * FROM "users" OFFSET 25',
            $this->builder->select()->offset(25)->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\LimitTrait::page
     */
    public function testPage()
    {
        // page starts with 1
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 30 OFFSET 30',
            $this->builder->select()->page(2)->getSql()
        );

        // change page length
        $this->assertEquals(
            'SELECT * FROM "users" LIMIT 10 OFFSET 20',
            $this->builder->select()->page(3, 10)->getSql()
        );
    }
}


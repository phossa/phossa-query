<?php
namespace Phossa\Query\Statement\Clause;

use Phossa\Query\Builder;

/**
 * BeforeAfterTrait test case.
 */
class BeforeAfterTraitTest extends \PHPUnit_Framework_TestCase
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
     * @covers Phossa\Query\Statement\Clause\BeforeAfterTrait::before
     */
    public function testBefore()
    {
        $this->assertEquals(
            'SELECT HIGH_PRIORITY * FROM "users"',
            $this->builder->select()->before('column', 'HIGH_PRIORITY')->getSql()
        );

        // multiple before
        $this->assertEquals(
            'SELECT HIGH_PRIORITY SQL_CACHE * FROM "users"',
            $this->builder->select()
                ->before('column', 'HIGH_PRIORITY')
                ->before('column', 'SQL_CACHE')
                ->getSql()
        );
    }

    /**
     * @covers Phossa\Query\Statement\Clause\BeforeAfterTrait::after
     */
    public function testAfter()
    {
        $this->assertEquals(
            'SELECT * FROM "users" PARTITION p1',
            $this->builder->select()
                ->after('from', 'PARTITION p1')
                ->getSql()
        );
    }
}


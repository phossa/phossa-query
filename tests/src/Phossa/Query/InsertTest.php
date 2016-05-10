<?php
namespace Phossa\Query;

use Phossa\Query\Builder;

/**
 * Insert test case.
 */
class InsertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * builder object
     *
     * @var    Builder
     * @access protected
     */
    protected $builder;

    /**
     * beautiful settings
     *
     * @var    array
     * @access protected
     */
    protected $settings = [
        'seperator'     => "\n",
        'indent'        => "    ",
    ];

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
     * insert from select query
     *
     * @covers Phossa\Query\Dialect\Common::insert()
     */
    public function testInsert01()
    {
        $str = 'INSERT INTO "users" SELECT "user_id", "user_name" FROM "oldusers"';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->insert()
                ->into("users")
                ->select(['user_id', 'user_name'])
                    ->from('oldusers')
                    ->getSql()
        );
    }
}


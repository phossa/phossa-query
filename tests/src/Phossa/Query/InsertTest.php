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
     * simple insert
     *
     * @covers Phossa\Query\Dialect\Common::insert()
     */
    public function testInsert01()
    {
        // normal spacing
        $str1 = 'INSERT INTO "users" ("uid", "uname") VALUES (2, \'phossa\')';
        $ins  = $this->builder->insert()
                    ->into("users")
                    ->set('uid', 2)
                    ->set('uname', 'phossa');

        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str1), $ins->getSql()
        );

        // indented spacing
        $str2 = <<<EOT
INSERT
INTO "users"
    ("uid", "uname")
VALUES
    (2, 'phossa')
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str2), $ins->getSql($this->settings)
        );

        // positioned param
        $str3 = 'INSERT INTO "users" ("uid", "uname") VALUES (?, ?)';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str3),
            $ins->getSql(['positionedParam' => true])
        );
        $this->assertEquals([2, 'phossa'], $ins->getBindings());
    }

    /**
     * insert multiple rows
     *
     * @covers Phossa\Query\Dialect\Common::insert()
     */
    public function testInsert02()
    {
        // 2 seperate rows
        $str1 = 'INSERT INTO "users" ("uid", "uname") VALUES (2, \'phossa\'), (3, \'test\')';
        $ins1 = $this->builder->insert()
            ->into("users")
            ->set(['uid' => 2, 'uname' => 'phossa'])
            ->set(['uid' => 3, 'uname' => 'test']);

        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str1), $ins1->getSql()
        );

        // positioned params
        $str2 = 'INSERT INTO "users" ("uid", "uname") VALUES (?, ?), (?, ?)';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str2),
            $ins1->getSql(['positionedParam' => true])
        );
        $this->assertEquals([2, 'phossa', 3, 'test'], $ins1->getBindings());

        // set in one func, with DEFAULT values
        $ins2 = $this->builder->insert()
            ->into("users")
            ->set([
                ['uid' => 2, 'uname' => 'phossa'],
                ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
            ]);

        $str3 = 'INSERT INTO "users" ("uid", "uname", "phone") VALUES (2, \'phossa\', DEFAULT), (3, \'test\', \'1234\')';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str3), $ins2->getSql()
        );

        // use NULL instead of DEFAULT
        $str4 = 'INSERT INTO "users" ("uid", "uname", "phone") VALUES (2, \'phossa\', NULL), (3, \'test\', \'1234\')';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str4), $ins2->getSql(['useNullAsDefault' => true])
        );
    }

    /**
     * INSERT ... SELECT
     *
     * @covers Phossa\Query\Dialect\Common::insert()
     */
    public function testInsert03()
    {
        // 2 seperate rows
        $str1 = 'INSERT INTO "users" ("uid", "uname") SELECT "user_id", "user_name" FROM "oldusers"';
        $ins1 = $this->builder->insert()
            ->into("users")
            ->set(['uid', 'uname'])
            ->select(['user_id', 'user_name'])
                ->from('oldusers');

        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str1), $ins1->getSql()
        );
    }
}

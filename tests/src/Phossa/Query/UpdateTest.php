<?php
namespace Phossa\Query;

use Phossa\Query\Builder;

/**
 * Update test case.
 */
class UpdateTest extends \PHPUnit_Framework_TestCase
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
     * simple update
     *
     * @covers Phossa\Query\Dialect\Common::update()
     */
    public function testUpdate01()
    {
        // update
        $str1 = <<<EOT
UPDATE
    "users"
SET
    "uid" = 2,
    "uname" = 'phossa'
WHERE
    "uid" = 10
EOT;
        $ins  = $this->builder->update()
                    ->table("users")
                    ->set('uid', 2)
                    ->set('uname', 'phossa')
                    ->where('uid', 10);

        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str1),
            $ins->getStatement($this->settings)
        );

        // positioned params
        $str2 = 'UPDATE "users" SET "uid" = ?, "uname" = ? WHERE "uid" = ?';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str2),
            $ins->getStatement(['positionedParam' => true])
        );
    }
}

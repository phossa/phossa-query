<?php
namespace Phossa\Query;

use Phossa\Query\Builder;
use Phossa\Query\Dialect\Mysql;

/**
 * README test case.
 */
class ReadmeTest extends \PHPUnit_Framework_TestCase
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

        $this->builder = new Builder('users', [], new Mysql());
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
     * example1: simple
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme01()
    {
        // builder object
        $users = $this->builder;

        // 01
        $this->assertEquals(
            "SELECT * FROM `users` LIMIT 10",
            $users->select()->limit(10)->getStatement()
        );

        // 02
        $this->assertEquals(
            "INSERT INTO `users` (`usr_name`) VALUES ('phossa')",
            $users->insert(['usr_name' => 'phossa'])->getStatement()
        );

        // 03
        $sales = $users->table(['sales' => 's']);
        $query = $sales->select()->where('user_id', 12);

        $this->assertEquals(
            "SELECT * FROM `sales` AS `s` WHERE `user_id` = ?",
            $query->getStatement(['positionedParam' => true])
        );

        // [ 12 ]
        $this->assertEquals([12], $query->getBindings());
    }

    /**
     * example2: col
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme02()
    {
        // builder object
        $users = $this->builder;

        // 01: col alias
        $this->assertEquals(
            "SELECT `user_name` AS `n` FROM `users`",
            $users->select('user_name', 'n')->getStatement()
        );

        // 02: `col()` with array
        $this->assertEquals(
            "SELECT `id`, `user_name` AS `n` FROM `users`",
            $users->select()->col(['id', 'user_name' => 'n'])->getStatement()
        );

        // 03: multiple `col()`
        $this->assertEquals(
            "SELECT `id`, `user_name` AS `n` FROM `users`",
            $users->select()->col('id')->field('user_name', 'n')->getStatement()
        );

        // 04: raw col
        $this->assertEquals(
            "SELECT COUNT(user_id) AS `cnt` FROM `users`",
            $users->select()->colRaw(['COUNT(user_id)' => 'cnt'])->getStatement()
        );

        // 05: predefined functions
        $this->assertEquals(
            "SELECT COUNT(`user_id`) AS `cnt`, MAX(`user_id`) AS `max_id` FROM `users`",
            $users->select()->count('user_id', 'cnt')->max('user_id', 'max_id')->getStatement()
        );

        // 05: new functions
        $this->assertEquals(
            "SELECT CONCAT(`user_name`, \"XXX\") AS `new_name` FROM `users`",
            $users->select()->func('CONCAT(%s, "XXX")', 'user_name', 'new_name')->getStatement()
        );
    }

    /**
     * example3: distinct
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme03()
    {
        // builder object
        $users = $this->builder;

        // 01: distinct
        $this->assertEquals(
            "SELECT DISTINCT `user_alias` FROM `users`",
            $users->select('user_alias')->distinct()
        );
    }

    /**
     * example4: from
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme04()
    {
        // builder object
        $users = $this->builder;

        // 01: different table
        $this->assertEquals(
            "SELECT * FROM `sales` AS `s`",
            $users->select(false)->from('sales', 's')->getStatement()
        );

        // 02: multiple tables
        $this->assertEquals(
            "SELECT * FROM `users`, `sales`",
            $users->select()->from('sales')->getStatement()
        );

        // 03: array
        $this->assertEquals(
            "SELECT * FROM `users` AS `u`, `accounts` AS `a`",
            $users->select(false)->from(['users' => 'u', 'accounts' => 'a'])->getStatement()
        );

        // 04: subselect
        $builder = $users->table(''); // clear table
        $this->assertEquals(
            "SELECT * FROM (SELECT `user_id` FROM `oldusers`) AS `u`",
            $builder->select()->from($builder->select('user_id')->from('oldusers'), 'u')->getStatement()
        );
    }

    /**
     * example5: group by
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme05()
    {
        // builder object
        $users = $this->builder;

        // 01:
        $this->assertEquals(
            "SELECT `group_id`, COUNT(*) AS `cnt` FROM `users` GROUP BY `group_id`",
            $users->select()->col('group_id')->count('*', 'cnt')->groupBy('group_id')->getStatement()
        );

        // 02: raw mode and multiple groupby
        $this->assertEquals(
            "SELECT `group_id`, `age`, COUNT(*) AS `cnt` FROM `users` GROUP BY `group_id`, age ASC",
            $users->select()->col('group_id')->col('age')->count('*', 'cnt')->groupBy('group_id')->groupByRaw('age ASC')->getStatement()
        );
    }
}

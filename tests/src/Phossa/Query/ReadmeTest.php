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

    /**
     * example6: join
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme06()
    {
        // builder object
        $users = $this->builder;

        // 01: two tables with same column name
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `accounts` ON `users`.`id` = `accounts`.`id`",
            $users->select()->join('accounts', 'id')->getStatement()
        );

        // 02: alias for the join table
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`",
            $users->select()->join('accounts a', 'id')->getStatement()
        );

        // 03: join table with different column name
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`user_id`",
            $users->select()->join('accounts a', 'id', 'user_id')->getStatement()
        );

        // 04: join table with operator specified
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `accounts` AS `a` ON `users`.`id` <> `a`.`user_id`",
            $users->select()->join('accounts a', 'id', '<>', 'user_id')->getStatement()
        );

        // 05: complex ON
        $builder = $users->table('');
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `sales` (ON `users`.`uid` = `sales`.`s_uid` OR `users`.`uid` = `sales`.`puid`)",
            $users->select()->join('sales',
                $builder->expr()->on('users.uid', 'sales.s_uid')->orOn('users.uid', 'sales.puid')
            )->getStatement()
        );

        // 06: multiple joins
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN `sales` AS `s` ON `users`.`uid` = `s`.`uid` INNER JOIN `order` AS `o` ON `users`.`uid` = `o`.`o_uid`",
            $users->select()
                ->join('sales s', 'uid', '=', 'uid')
                ->join('order o', 'uid', 'o_uid')
                ->getStatement()
        );

        // 07: join with subqueries
        $this->assertEquals(
            "SELECT * FROM `users` INNER JOIN (SELECT `uid` FROM `oldusers`) AS `x` ON `users`.`uid` = `x`.`uid`",
            $users->select()->join(
                $builder->select('uid')->from('oldusers')->alias('x'),
                'uid'
            )->getStatement()
        );

        // 08: other joins
        $this->assertEquals(
            "SELECT * FROM `users` OUTER JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`",
            $users->select()->outerJoin('accounts a', 'id')->getStatement()
        );

        // 09: realJoin
        $this->assertEquals(
            "SELECT * FROM `users` NATURAL JOIN `accounts` AS `a` ON `users`.`id` = `a`.`id`",
            $users->select()->realJoin('NATURAL', 'accounts a', 'id')->getStatement()
        );
    }

    /**
     * example7: limit
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme07()
    {
        // builder object
        $users = $this->builder;

        // 01: limit
        $this->assertEquals(
            "SELECT * FROM `users` LIMIT 30 OFFSET 10",
            $users->select()->limit(30, 10)->getStatement()
        );

        // 02: offset
        $this->assertEquals(
            "SELECT * FROM `users` LIMIT 20 OFFSET 15",
            $users->select()->limit(20)->offset(15)->getStatement()
        );

        // 03: page, start from 1
        $this->assertEquals(
            "SELECT * FROM `users` LIMIT 30 OFFSET 60",
            $users->select()->page(3, 30)->getStatement()
        );
    }

    /**
     * example8: order by
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme08()
    {
        // builder object
        $users = $this->builder;

        // 01: asc desc
        $this->assertEquals(
            "SELECT * FROM `users` ORDER BY `age` ASC, `score` DESC",
            $users->select()->orderByAsc('age')->orderByDesc('score')->getStatement()
        );

        // 02: raw mode
        $this->assertEquals(
            "SELECT * FROM `users` ORDER BY age ASC, score DESC",
            $users->select()->orderByRaw('age ASC, score DESC')->getStatement()
        );
    }

    /**
     * example9: where
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme09()
    {
        // builder object
        $users   = $this->builder;
        $builder = $users->table('');

        // 01: simple raw mode
        $this->assertEquals(
            "SELECT * FROM `users` WHERE age > 18",
            $users->select()->where('age > 18')->getStatement()
        );

        // 02: col, val
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` = 18",
            $users->select()->where('age', 18)->getStatement()
        );

        // 03: col, operator, val
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` < 18",
            $users->select()->where('age', '<', 18)->getStatement()
        );

        // 04: with array
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` > 18 AND `gender` = 'male'",
            $users->select()->where(['age' => ['>', 18], 'gender' => 'male'])->getStatement()
        );

        // 05: multiple wheres
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` > 18 AND `gender` = 'male'",
            $users->select()->where('age', '>', 18)->where('gender','male')->getStatement()
        );

        // 06: complex where
        $this->assertEquals(
            "SELECT * FROM `users` WHERE (`id` = 1 OR (`id` < 20 OR `id` > 100)) OR `name` = 'Tester'",
            $users->select()->where(
                $builder->expr()->where('id', 1)->orWhere(
                    $builder->expr()->where('id', '<', 20)->orWhere('id', '>', 100)
                )
             )->orWhere('name', 'Tester')->getStatement()
        );

        // 07: raw mode
        $this->assertEquals(
            "SELECT * FROM `users` WHERE age = 18 OR score > 90",
            $users->select()->whereRaw('age = 18')->orWhereRaw('score > 90')->getStatement()
        );

        // 08: not
        $this->assertEquals(
            "SELECT * FROM `users` WHERE NOT `age` = 18 OR NOT `score` > 90",
            $users->select()->whereNot('age', 18)->orWhereNot('score', '>', 90)
                ->getStatement()
        );

        // 09: IN & BETWEEN
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` IN (10,12,15,18,20) OR `score` NOT BETWEEN 90 AND 100",
            $users->select()->whereIn('age', [10,12,15,18,20])
                ->orWhereNotBetween('score', 90, 100)
                ->getStatement()
        );

        // 10: Null
        $this->assertEquals(
            "SELECT * FROM `users` WHERE `age` IS NULL OR `score` IS NOT NULL",
            $users->select()->whereNull('age')->orWhereNotNull('score')->getStatement()
        );

        // 11: exists
        $qry1  = $users->select('user_id')->where('age', '>', 60);
        $sales = $users->table('sales');
        $this->assertEquals(
            "SELECT * FROM `sales` WHERE EXISTS (SELECT `user_id` FROM `users` WHERE `age` > 60)",
            $sales->select()->whereExists($qry1)->getStatement()
        );
    }

    /**
     * example10: having
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme10()
    {
        // builder object
        $users = $this->builder;

        // 01: having
        $this->assertEquals(
            "SELECT * FROM `users` HAVING `age` = 10 OR `level` > 20",
            $users->select()->having('age', 10)->orHaving('level', '>', 20)
                ->getStatement()
        );
    }

    /**
     * example11: union
     *
     * @covers Phossa\Query\Dialect\Common::select()
     */
    public function testReadme11()
    {
        // builder object
        $users = $this->builder;

        // 01: union & union all
        $this->assertEquals(
            "SELECT * FROM `users` UNION SELECT * FROM `oldusers1` UNION ALL SELECT `user_id` FROM `oldusers2`",
            $users->select()
                ->union()
                    ->select()->from('oldusers1')
                ->unionAll()
                    ->select('user_id')->from('oldusers2')
            ->getStatement()
        );
    }

    /**
     * example11: insert
     *
     * @covers Phossa\Query\Dialect\Common::insert()
     */
    public function testReadme12()
    {
        // builder object
        $users = $this->builder;

        // 01: insert
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa')",
            $users->insert()->set('uid', 2)->set('uname', 'phossa')
                ->getStatement()
        );

        // 02: array notation
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa')",
            $users->insert()->set(['uid' => 2, 'uname' => 'phossa'])
                ->getStatement()
        );

        // 03: multple rows
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`) VALUES (2, 'phossa'), (3, 'test')",
            $users->insert()
                ->set(['uid' => 2, 'uname' => 'phossa'])
                ->set(['uid' => 3, 'uname' => 'test'])
                ->getStatement()
        );

        // 04: with DEFAULT values
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', DEFAULT), (3, 'test', '1234')",
            $users->insert([
                ['uid' => 2, 'uname' => 'phossa'],
                ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
            ])->getStatement()
        );

        // 05: with NULL values
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`, `phone`) VALUES (2, 'phossa', NULL), (3, 'test', '1234')",
            $users->insert([
                ['uid' => 2, 'uname' => 'phossa'],
                ['uid' => 3, 'uname' => 'test', 'phone' => '1234']
            ])->getStatement(['useNullAsDefault' => true])
        );

        // 06: INSERT ... SELECT
        $this->assertEquals(
            "INSERT INTO `users` (`uid`, `uname`) SELECT `user_id`, `user_name` FROM `oldusers`",
            $users->insert()->set(['uid', 'uname'])
                ->select(['user_id', 'user_name'])
                ->from('oldusers')
                ->getStatement()
        );
    }
}

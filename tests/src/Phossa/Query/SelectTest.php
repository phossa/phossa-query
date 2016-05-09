<?php
namespace Phossa\Query;

use Phossa\Query\Builder;

/**
 * Select test case.
 */
class SelectTest extends \PHPUnit_Framework_TestCase
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
     * multiple columns
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect01()
    {
        $str = <<<EOT
SELECT
    "name",
    MIN(test_score),
    MAX(test_score),
    GROUP_CONCAT(DISTINCT test_score ORDER BY test_score DESC SEPARATOR ' ')
FROM
    "students"
GROUP BY
    "name"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->col("name")
                ->col("MIN(test_score)")
                ->col("MAX(test_score)")
                ->col("GROUP_CONCAT(DISTINCT test_score ORDER BY test_score DESC SEPARATOR ' ')")
                ->from("students")
                ->groupBy("name")
                ->getSql($this->settings)
        );
    }

    /**
     * try "  " as indent
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect02()
    {
        $str = <<<EOT
SELECT
  *
FROM
  students
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()->from("students")->getSql([
                'seperator' => "\n",
                'indent'    => "  ",
                'autoQuote' => false,
            ])
        );
    }

    /**
     * multiple tables
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect03()
    {
        $str = <<<EOT
SELECT
    *
FROM
    "students",
    "lecturers" AS "l",
    "admins"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students")
                ->from("lecturers", "l")
                ->from("admins")
                ->getSql($this->settings)
        );
    }

    /**
     * subquery as table
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect04()
    {
        $str = <<<EOT
SELECT
    "s"."id"
FROM
    (SELECT * FROM "students") AS "s"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from( $this->builder->select()->from("students"), 's')
                ->col('s.id')
                ->getSql($this->settings)
        );
    }

    /**
     * table prefix for column, field() is alias of col()
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect05()
    {
        $str = <<<EOT
SELECT
    "id",
    "students"."name"
FROM
    "students"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students")
                ->field("id")
                ->field("students.name")
                ->getSql($this->settings)
        );
    }

    /**
     * functions in column
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect06()
    {
        $str = <<<EOT
SELECT
    "s"."id",
    "s"."test_score" AS "Test score",
    DATE_FORMAT(s.date_taken, '%M %Y') AS "Taken on"
FROM
    "students" AS "s"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students", "s")
                ->field("s.id")
                ->field("s.test_score", "Test score")
                ->field("DATE_FORMAT(s.date_taken, '%M %Y')", "Taken on")
                ->getSql($this->settings)
        );
    }

    /**
     * subquery in column
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect07()
    {
        $str = <<<EOT
SELECT
    SELECT MAX("score") FROM "scores" AS "score"
FROM
    "students" AS "s"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students", "s")
                ->field($this->builder->select()->max("score")->from("scores"), 'score')
                ->getSql($this->settings)
        );
    }

    /**
     * select distinct
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect08()
    {
        $str = <<<EOT
SELECT
DISTINCT
    "id"
FROM
    "students"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students")
                ->field("id")
                ->distinct()
                ->getSql($this->settings)
        );
    }

    /**
     * joins
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect09()
    {
        $str = 'SELECT * FROM "students" INNER JOIN teachers';
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from("students")
                ->join("teachers")
                ->getSql()
        );
    }

    /**
     * join with conditions
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect10()
    {
        $str = <<<EOT
SELECT
    "students"."id"
FROM
    "students"
    LEFT JOIN "teachers" ON "students"."id" = "teachers"."student_id"
    RIGHT JOIN "jailed" AS "j" ON "j"."student_id" = "students"."id"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("students.id")
                ->from("students")
                ->leftJoin("teachers", "students.id", "teachers.student_id")
                ->rightJoin("jailed j", "j.student_id", "students.id")
                ->getSql($this->settings)
        );
    }

    /**
     * join with subquery
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect11()
    {
        $str = <<<EOT
SELECT
    *
FROM
    "marks" AS "m"
    INNER JOIN (SELECT * FROM "students") AS "s" ON "s"."id" = "m"."id"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->from('marks', 'm')
                ->join($this->builder->select()->from('students')->alias('s'), 's.id', 'm.id')
                ->getSql($this->settings)
        );
    }

    /**
     * filter with WHERE
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect12()
    {
        $str = "SELECT id FROM students WHERE name = 'Thomas'";
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->where("name", "Thomas")
                ->getSql(['autoQuote' => false])
        );
    }

    /**
     * subquery in WHERE
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect13()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
WHERE
    "score" = (SELECT MAX("score") FROM "scores")
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->where("score", $this->builder->select()->max('score')->from('scores'))
                ->getSql($this->settings)
        );
    }

    /**
     * multiple WHEREs
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect14()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
WHERE
    "name" = 'Thomas'
    OR "age" > 18
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->where("name","Thomas")
                ->orWhere("age", ">", 18)
                ->getSql($this->settings)
        );
    }

    /**
     * expressions in WHERE
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect15()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
WHERE
    ("name" = 'Thomas' OR "age" > 18)
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->where(
                    $this->builder->expr()
                        ->andWhere("name", "Thomas")
                        ->orWhere("age", ">", 18)
                )
                ->getSql($this->settings)
        );
    }

    /**
     * order by
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect16()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
ORDER BY
    "id" ASC,
    "name" DESC
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->orderByAsc("id")
                ->orderByDesc("name")
                ->getSql($this->settings)
        );
    }

    /**
     * group by
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect17()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
GROUP BY
    "id",
    "students"."name"
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->groupBy("id")
                ->groupBy("students.name")
                ->getSql($this->settings)
        );
    }

    /**
     * having
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect18()
    {
        $str = <<<EOT
SELECT
    "id"
FROM
    "students"
GROUP BY
    "id"
HAVING
    "a" = 2
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field("id")
                ->from("students")
                ->groupBy("id")
                ->having("a", 2)
                ->getSql($this->settings)
        );
    }

    /**
     * pass as raw
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect19()
    {
        $str = <<<EOT
SELECT
    id
FROM
    "students"
WHERE
    "time" = NOW()
EOT;
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $this->builder->select()
                ->field($this->builder->raw("id"))
                ->from("students")
                ->where("time", $this->builder->raw('NOW()'))
                ->getSql($this->settings)
        );
    }

    /**
     * pass parameters
     *
     * @covers Phossa\Query\Statement\Select::select()
     */
    public function testSelect20()
    {
        $str = 'SELECT * FROM "students" WHERE "age" IN RANGE(?, ?)';

        $sel = $this->builder->select()
                ->from("students")
                ->where("age", "IN", $this->builder->raw('RANGE(?, ?)', 1, 1.2));
        $this->assertEquals(
            preg_replace("/\r\n/","\n", $str),
            $sel->getSql(['positionedParam' => true])
        );

        $this->assertEquals([1,1.2], $sel->getBindings());
    }
}


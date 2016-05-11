<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Library
 * @package   Phossa\Query
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Query\Clause;

use Phossa\Query\Dialect\Common\CreateTableStatementInterface;

/**
 * CreateTableTrait
 *
 * @package package_name
 * @author  Hong Zhang <phossa@126.com>
 * @see     CreateTableStatementInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait CreateTableTrait
{
    /**
     * SELECT ... LIKE
     *
     * @var    string
     * @access protected
     */
    protected $like;

    /**
     * @var    bool
     * @access protected
     */
    protected $temporary = false;

    /**
     * @var    bool
     * @access protected
     */
    protected $if_not_exists = false;

    /**
     * CREATE TEMPORARY TABLE ...
     *
     * @return self
     * @access public
     */
    public function temp()
    {
        $this->temporary = true;
        return $this;
    }

    /**
     * CREATE TABLE IF NOT EXISTS ...
     *
     * @return self
     * @access public
     */
    public function ifNotExists()
    {
        $this->if_not_exists = true;
        return $this;
    }

    /**
     * CREATE TABLE ... LIKE
     *
     * @param  string $tableName
     * @return self
     * @access public
     */
    public function like(/*# string */ $tableName)
    {
        $this->like = $tableName;
        return $this;
    }

    /**
     * CREATE TABLE ... SELECT ...
     *
     * @return SelectStatementInterface
     * @access public
     */
    public function select()/*# : SelectStatementInterface */
    {
        $cols = func_get_args();
        return $this->getBuilder()->setPrevious($this)->select(false)
        ->col($cols);
    }

    /**
     * build LIKE
     *
     * @access protected
     */
    protected function buildLike()
    {
        if ($this->like) {
            return ['LIKE ' . $this->quote($this->like)];
        } else {
            return [];
        }
    }
}

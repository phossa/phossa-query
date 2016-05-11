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

namespace Phossa\Query\Dialect;

use Phossa\Query\Dialect\Common\Select;
use Phossa\Query\Dialect\Common\Insert;
use Phossa\Query\Builder\BuilderInterface;
use Phossa\Query\Dialect\Common\SelectStatementInterface;
use Phossa\Query\Dialect\Common\InsertStatementInterface;

/**
 * Standard Query Language dialect
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     DialectInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Common implements DialectInterface
{
    /**
     * Current dialect string
     *
     * @var    string
     * @access protected
     */
    protected $dialect = 'Common';

    /**
     * quote prefix
     *
     * @var    string
     * @access protected
     */
    protected $quote_prefix = '"';

    /**
     * quote suffix
     *
     * @var    string
     * @access protected
     */
    protected $quote_suffix = '"';

    /**
     * {@inheritDoc}
     */
    public function select(BuilderInterface $builder)/*# : SelectStatementInterface */
    {
        $class = __NAMESPACE__ . '\\' . $this->dialect . '\\Select';
        return new $class($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function insert(BuilderInterface $builder)/*# : InsertStatementInterface */
    {
        $class = __NAMESPACE__ . '\\' . $this->dialect . '\\Insert';
        return new $class($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function update(BuilderInterface $builder)/*# : UpdateStatementInterface */
    {
        $class = __NAMESPACE__ . '\\' . $this->dialect . '\\Update';
        return new $class($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(BuilderInterface $builder)/*# : DeleteStatementInterface */
    {
        $class = __NAMESPACE__ . '\\' . $this->dialect . '\\Delete';
        return new $class($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function create(BuilderInterface $builder)/*# : CreateInterface */
    {
        $class = __NAMESPACE__ . '\\' . $this->dialect . '\\Create';
        return new $class($builder);
    }

    /**
     * {@inheritDoc}
     */
    public function quote(
        /*# string */ $string,
        /*# bool */ $quote = DialectInterface::QUOTE_YES
    )/*# : string */ {
        $pref = $this->quote_prefix;
        $suff = $this->quote_suffix;

        // space found
        if (preg_match("/[ \n(),]/", $string)) {
            // quote it anyway
            if ($quote & DialectInterface::QUOTE_SPACE) {
                return sprintf('%s%s%s', $pref, $string, $suff);

            // abort
            } else {
                return $string;
            }
        }

        if ($quote & DialectInterface::QUOTE_YES) {
            $string = preg_replace_callback(
                '/\b([0-9a-zA-Z\$_]++)\b/',
                function($m) use ($pref, $suff) {
                    return sprintf('%s%s%s', $pref, $m[1], $suff);
                },
                $string
            );
        }
        return $string;
    }
}

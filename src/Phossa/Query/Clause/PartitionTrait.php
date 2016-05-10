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

/**
 * PartitionTrait
 *
 * @package Phossa\Query
 * @author  Hong Zhang <phossa@126.com>
 * @see     PartitionInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait PartitionTrait
{
    /**
     * Partition
     *
     * @var    array
     * @access protected
     */
    protected $clause_partition = [];

    /**
     * {@inheritDoc}
     */
    public function partition($partitionName)
    {
        if (is_array($partitionName)) {
            $this->clause_partition = array_merge(
                $this->clause_partition, $partitionName
            );
        } else {
            $this->clause_partition[] = $partitionName;
        }
        return $this;
    }

    /**
     * Build PARTITION
     *
     * @return array
     * @access protected
     */
    protected function buildPartition()/*# : array */
    {
        $result = [];
        if (!empty($this->clause_partition)) {
            $result[] = 'PARTITION (' . join(', ', $this->clause_partition) . ')';
        }
        return $result;
    }
}

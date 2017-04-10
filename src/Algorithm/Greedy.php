<?php

namespace drupol\phpartition\Algorithm;

use drupol\phpartition\BasePartitionAlgorithm;
use drupol\phpartition\Partition;
use drupol\phpartition\PartitionAlgorithmInterface;

/**
 * Class Greedy.
 *
 * @package drupol\phpartition\Algorithm
 */
class Greedy extends BasePartitionAlgorithm implements PartitionAlgorithmInterface
{

  /**
   * {@inheritdoc}
   */
    public function getResult()
    {
        // The greedy algorithm needs the input data to be sorted (desc).
        $this->getDataPartition()->sortByValue('DESC');
        return parent::getResult();
    }

  /**
   * {@inheritdoc}
   */
    public function getPartitionWeight(Partition $partition)
    {
        return $partition->getWeight();
    }
}

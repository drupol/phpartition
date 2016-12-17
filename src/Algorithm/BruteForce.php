<?php

namespace drupol\phpartition\Algorithm;

use drupol\phpartition\BasePartitionAlgorithm;
use drupol\phpartition\PartitionAlgorithmInterface;
use drupol\phpermutations\Permutations;

/**
 * Class BruteForce.
 *
 * @package drupol\phpartition\Algorithm
 */
class BruteForce extends BasePartitionAlgorithm implements PartitionAlgorithmInterface {

  /**
   * {@inheritdoc}
   */
  public function getResult() {
    $this->getDataPartition()->sortByValue('ASC');
    $partitionSize = ($this->getSize() > $this->getDataPartition()->count()) ? $this->getDataPartition()->count() : $this->getSize();

    for ($p = $partitionSize; $p > 1; $p--) {
      $best = $this->getDataPartition()->getWeight();
      $target = ($best) / $p;
      $goodSubset = array();
      $maxSize = floor($this->getDataPartition()->count() / $p);

      for ($i = 1; $i <= $maxSize; $i++) {
        $permutations = new Permutations($this->getDataPartition()->values(), $i);
        foreach ($permutations->generator() as $subset) {
          $x = 0;
          foreach ($subset as $item) {
            $x += $item->getValue();
            if (abs($x - $target) - abs($best - $target) < 0) {
              $best = $x;
              $goodSubset = $subset;
            }
          }
        }
      }

      $this->getPartitionContainer()->insert($this->getPartition()->addItems($goodSubset));
      $this->getDataPartition()->deleteItems($goodSubset);
    }

    $this->getPartitionContainer()->insert($this->getPartition()->addItems($this->getDataPartition()->all()));

    return $this->getPartitionContainer()->getPartitionsItemsArray();
  }

}

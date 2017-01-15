<?php

namespace drupol\phpartition\Algorithm;

use drupol\phpartition\BasePartitionAlgorithm;
use drupol\phpartition\Partition;
use drupol\phpartition\PartitionAlgorithmInterface;
use drupol\phpermutations\Permutations;
use Oefenweb\Statistics\Statistics;

/**
 * Class BruteForceCustomA.
 *
 * @package drupol\phpartition\Algorithm
 */
class BruteForceCustomA extends BasePartitionAlgorithm implements PartitionAlgorithmInterface {

  /**
   * {@inheritdoc}
   */
  public function getResult() {
    // Sort the initial data set ascending.
    $this->getDataPartition()->sortByValue('ASC');
    // Compute the maximum value of the variance.
    $variance = pow(2, $this->getDataPartition()->size());
    // Set a default value for the variable that will contain the solution.
    $solution = NULL;
    // Get the number of elements in the input dataset.
    $count = $this->getDataPartition()->size();
    // Compute the size of a chunk. Ceiling the value because it cannot be zero.
    $chunkSize = ceil($count / $this->getSize());
    // Get the rest of the division of the element count by the number of
    // partitions.
    $rest = $count % $this->getSize();

    $permutations = new Permutations($this->getDataPartition()->toArray());

    // Loop through each permutation and
    // compute the variance of each subsetchunks.
    $i = 0;
    foreach ($permutations->generator() as $subset) {
      $i++;
      // Get the variance of the sums array.
      $varianceCandidate = Statistics::variance(
        array_map(function ($items) {
          $partition = new Partition();
          $partition->addItems($items);
          return $partition->getWeight();
        }, array_chunk($subset, $chunkSize)
        )
      );

      // If we've found a better variance with this subset, store it.
      if ($varianceCandidate < $variance) {
        $variance = $varianceCandidate;
        $solution = $subset;

        // If the variance is equal to the size of the set module the number of
        // partition that we want, that means that's the best candidate,
        // store the value and exit the loop prematurely.
        if ($rest == $varianceCandidate) {
          break;
        }
      }
    }

    // Store each chunks into a subset in the SubsetContainer.
    foreach (array_chunk($solution, $chunkSize) as $subsetChunks) {
      $this->getPartitionContainer()->insert($this->getPartition()->addItems($subsetChunks));
    }

    return $this->getPartitionContainer()->getPartitionsItemsArray();
  }

}

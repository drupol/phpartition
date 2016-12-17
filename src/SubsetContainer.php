<?php

namespace drupol\phpartition;

class SubsetContainer extends \SplHeap {

  /**
   * @var BasePartitionAlgorithm
   */
  protected $algo;

  /**
   * Override compare method.
   *
   * @param Subset $a
   * @param Subset $b
   *
   * @return int
   */
  public function compare($a, $b) {
    $al = $a->getAlgo()->getSubsetWeight($a);
    $bl = $b->getAlgo()->getSubsetWeight($b);

    if ($al == $bl) {
      return 0;
    }
    return ($al > $bl) ? -1 : +1;
  }

  /**
   * @param $partition
   */
  public function setPartition($partition) {
    for($i=0; $i<$partition; $i++) {
      $subset = new Subset();
      $subset->setAlgo($this->getAlgo());
      $this->insert($subset);
    }
  }

  /**
   * @param SubsetItem[] $items
   */
  public function addItemsToSubset(array $items = array()) {
    foreach ($items as $item) {
      $this->addItemToSubset($item);
    }
  }

  /**
   * @param \drupol\phpartition\SubsetItem $item
   */
  public function addItemToSubset(SubsetItem $item) {
    $this->top();
    $subset = $this->extract();
    $subset->addItem($item);
    $this->insert($subset);
  }

  /**
   * @return Subset[]
   */
  public function getSubsets() {
    $data = array();
    $clone = clone $this;

    for($clone->top(); $clone->valid(); $clone->next()) {
      $data[] = $clone->current();
    }

    return $data;
  }

  /**
   * @return array
   */
  public function getSubsetsAndItemsAsArray() {
    $data = array();

    foreach ($this->getSubsets() as $subset) {
      $data[] = $subset->getRawItems();
      }

    return array_values(array_filter($data));
  }

  /**
   * @param \drupol\phpartition\BasePartitionAlgorithm $algo
   */
  public function setAlgo(BasePartitionAlgorithm $algo) {
    $this->algo = $algo;
  }

  /**
   * @return BasePartitionAlgorithm
   */
  public function getAlgo() {
    return $this->algo;
  }

}

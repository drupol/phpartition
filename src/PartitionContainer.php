<?php

namespace drupol\phpartition;

/**
 * Class PartitionContainer.
 *
 * @package drupol\phpartition
 */
class PartitionContainer extends \SplHeap {

  /**
   * The algorithm to use.
   *
   * @var BasePartitionAlgorithm
   */
  protected $algo;

  /**
   * The number of partition to use.
   *
   * @var int
   */
  protected $size;

  /**
   * Override compare method.
   *
   * @param Partition $partitionA
   *   The first partition.
   * @param Partition $partitionB
   *   The second partition.
   *
   *   {@inheritdoc}.
   */
  public function compare($partitionA, $partitionB) {
    $partitionAWeight = $partitionA->getAlgo()->getPartitionWeight($partitionA);
    $partitionBWeight = $partitionB->getAlgo()->getPartitionWeight($partitionB);

    if ($partitionAWeight == $partitionBWeight) {
      return 0;
    }

    return ($partitionAWeight > $partitionBWeight) ? -1 : +1;
  }

  /**
   * Set the size of the container.
   *
   * @param int $size
   *   The size.
   */
  public function setSize($size) {
    $this->size = $size;

    for ($i = 0; $i < $size; $i++) {
      $subset = new Partition();
      $subset->setAlgo($this->getAlgo());
      $this->insert($subset);
    }
  }

  /**
   * Return the size of the container.
   *
   * @return int
   *   The number of partitions the container has.
   */
  public function getSize() {
    return $this->size;
  }

  /**
   * Add items to the partition.
   *
   * @param PartitionItem[] $items
   *   The items to add.
   */
  public function addItemsToPartition(array $items = array()) {
    foreach ($items as $item) {
      $this->addItemToPartition($item);
    }
  }

  /**
   * Add an item to the first partition.
   *
   * @param \drupol\phpartition\PartitionItem $item
   *   The item to add.
   */
  public function addItemToPartition(PartitionItem $item) {
    $this->top();
    $subset = $this->extract();
    $subset->addItem($item);
    $this->insert($subset);
  }

  /**
   * Get the partition in the container.
   *
   * @return Partition[]
   *   An array of partitions.
   */
  public function getPartitions() {
    $data = array();
    $clone = clone $this;

    for ($clone->top(); $clone->valid(); $clone->next()) {
      $data[] = $clone->current();
    }

    return $data;
  }

  /**
   * Return the items from each partitions in the container.
   *
   * @return mixed[]
   *   The items.
   */
  public function getPartitionsItemsArray() {
    $data = array();

    foreach ($this->getPartitions() as $subset) {
      $data[] = $subset->getRawItems();
    }

    return array_values(array_filter($data));
  }

  /**
   * Set the algorithm to use.
   *
   * @param \drupol\phpartition\BasePartitionAlgorithm $algo
   *   The algorithm.
   */
  public function setAlgo(BasePartitionAlgorithm $algo) {
    $this->algo = $algo;
  }

  /**
   * Get the algorithm.
   *
   * @return BasePartitionAlgorithm
   *   The algorithm.
   */
  public function getAlgo() {
    return $this->algo;
  }

}

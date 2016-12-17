<?php

namespace drupol\phpartition;

/**
 * Interface PartitionAlgorithmInterface.
 *
 * @package drupol\phpartition
 */
interface PartitionAlgorithmInterface {

  /**
   * Set the number of partition to use.
   *
   * @param int $size
   *   The number of partition.
   */
  public function setSize($size);

  /**
   * Get the size, the number of partition to use.
   *
   * @return int
   *   The number of partition.
   */
  public function getSize();

  /**
   * Get the partition container object.
   *
   * @return PartitionContainer
   *   The partition container object.
   */
  public function getPartitionContainer();

  /**
   * Set the original data.
   *
   * @param mixed[] $data
   *   The original data.
   */
  public function setData(array $data = array());

  /**
   * Get the original data.
   *
   * @return mixed[]
   *   The original data.
   */
  public function getData();

  /**
   * Get the result as array chunks.
   *
   * @return array
   *   The result array.
   */
  public function getResult();

  /**
   * Set the function used to compute the value of an item.
   *
   * @param callable $callable
   *   The function.
   */
  public function setItemAccessCallback(callable $callable = NULL);

  /**
   * Get the function used to compute the value of an item.
   *
   * @return callable
   *   The function.
   */
  public function getItemAccessCallback();

  /**
   * Get the weight of a partition.
   *
   * @param \drupol\phpartition\Partition $partition
   *   The partition to get the weight from.
   *
   * @return int|float
   *   The weight.
   */
  public function getPartitionWeight(Partition $partition);

  /**
   * Get the original set of data as a partition.
   *
   * @return Partition
   *   A single partition containing the original items.
   */
  public function getDataPartition();

  /**
   * Set the original set of data partition.
   *
   * @param Partition $partition
   *   The partition.
   */
  public function setDataPartition(Partition $partition);

  /**
   * Generate the original data partition.
   *
   * @param mixed[] $items
   *   The original items.
   *
   * @return Partition
   *   The partition.
   */
  public function generateDataPartition(array $items = array());

  /**
   * Create and return a new partition, ready to use.
   *
   * @return Partition
   *   A new partition.
   */
  public function getPartition();

}

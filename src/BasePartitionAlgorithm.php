<?php

namespace drupol\phpartition;

/**
 * Class BasePartitionAlgorithm.
 *
 * @package drupol\phpartition
 */
abstract class BasePartitionAlgorithm implements PartitionAlgorithmInterface {

  /**
   * The original data.
   *
   * @var array
   */
  protected $data;

  /**
   * A single partition containing the original data in the right format.
   *
   * @var Partition
   */
  protected $dataPartition;

  /**
   * The partition container.
   *
   * @var PartitionContainer
   */
  protected $partitionContainer;

  /**
   * The function used to compute the value of an item.
   *
   * @var callable
   */
  protected $itemAccessCallback;

  /**
   * BasePartitionAlgorithm constructor.
   */
  public function __construct() {
    $this->partitionContainer = new PartitionContainer();
    $this->partitionContainer->setAlgo($this);
  }

  /**
   * {@inheritdoc}
   */
  public function setData(array $data = array()) {
    $this->data = $data;
    $this->setDataPartition($this->generateDataPartition($this->getData()));
  }

  /**
   * {@inheritdoc}
   */
  public function getData() {
    return $this->data;
  }

  /**
   * {@inheritdoc}
   */
  public function setDataPartition(Partition $partition) {
    $this->dataPartition = $partition;
  }

  /**
   * {@inheritdoc}
   */
  public function getDataPartition() {
    return $this->dataPartition;
  }

  /**
   * {@inheritdoc}
   */
  public function generateDataPartition(array $items = array()) {
    return $this->getPartition()->addItems(
      array_map(function ($item) {
        if ($item instanceof PartitionItemInterface) {
          return $item;
        }
        return new PartitionItem(
          $item,
          $this->getItemAccessCallback()
        );
      }, $items)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setSize($size) {
    $this->getPartitionContainer()->setSize($size);
  }

  /**
   * {@inheritdoc}
   */
  public function getSize() {
    return $this->getPartitionContainer()->getSize();
  }

  /**
   * {@inheritdoc}
   */
  public function setItemAccessCallback(callable $callable = NULL) {
    $this->itemAccessCallback = $callable;
    $this->setData($this->getData());
  }

  /**
   * {@inheritdoc}
   */
  public function getItemAccessCallback() {
    return $this->itemAccessCallback;
  }

  /**
   * {@inheritdoc}
   */
  public function getPartitionContainer() {
    return $this->partitionContainer;
  }

  /**
   * {@inheritdoc}
   */
  public function getResult() {
    $this->getPartitionContainer()->addItemsToPartition($this->getDataPartition()->all());

    return $this->getPartitionContainer()->getPartitionsItemsArray();
  }

  /**
   * {@inheritdoc}
   */
  public function getPartitionWeight(Partition $partition) {
    return $partition->count();
  }

  /**
   * {@inheritdoc}
   */
  public function getPartition() {
    $partition = new Partition();
    $partition->setAlgo($this);

    return $partition;
  }

}

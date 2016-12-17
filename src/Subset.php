<?php

namespace drupol\phpartition;

class Subset implements \Countable {

  /**
   * @var BasePartitionAlgorithm
   */
  protected $algo;

  /**
   * @var SubsetItem[]
   */
  protected $items;

  /**
   * @return int
   */
  public function count() {
    return count($this->getItems());
  }

  /**
   * @param \drupol\phpartition\SubsetItem $item
   */
  public function addItem(SubsetItem $item) {
    $this->items[$item->getKey()] = $item;
  }

  /**
   * @param SubsetItem[] $items
   */
  public function addItems(array $items = array()) {
    foreach ($items as $item) {
      $this->addItem($item);
    }
  }

  /**
   * @return SubsetItem[]
   */
  public function getItems() {
    return (array) $this->items;
  }

  /**
   * @param SubsetItem[] $items
   */
  public function setItems(array $items = array()) {
    $this->items = $items;
  }

  /**
   * @return array
   */
  public function getItemsValues() {
    $data = array();

    foreach ($this->getItems() as $item) {
      $data[$item->getKey()] = $item->getValue();
    }

    return $data;
  }

  /**
   * @return array
   */
  public function getRawItems() {
    $data = array();

    foreach ($this->getItems() as $item) {
      $data[] = $item->getItem();
    }

    return $data;
  }

  /**
   * @return int
   */
  public function getWeight() {
    $sum = 0;

    foreach ((array) $this->items as $item) {
      $sum += $item->getValue();
    }

    return $sum;
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

  /**
   * Clear the subset.
   */
  public function clear() {
    $this->setItems();
  }

  /**
   * @param $key
   *
   * @return \drupol\phpartition\SubsetItem
   */
  public function getItem($key) {
    return $this->items[$key];
  }

  /**
   * @param SubsetItem[] $items
   */
  public function deleteItems(array $items = array()) {
    foreach ($items as $item) {
      $this->delete($item);
    }
  }

  /**
   * @param \drupol\phpartition\SubsetItem $item
   */
  public function delete(SubsetItem $item) {
    foreach ($this->items as $key => $value) {
      if ($value->getKey() == $item->getKey()) {
        unset($this->items[$key]);
      }
    }
  }

  /**
   * @param string $order
   *
   * @return $this
   */
  public function sortByValue($order = 'ASC') {
    $data = $this->getItems();

    if ('ASC' == $order) {
      usort($data, function ($itemA, $itemB) {
        return $itemA->getValue() > $itemB->getValue();
      });
    }

    if ('DESC' == $order) {
      usort($data, function ($itemA, $itemB) {
        return $itemA->getValue() < $itemB->getValue();
      });
    }

    $this->setItems($data);

    return $this;
  }

}
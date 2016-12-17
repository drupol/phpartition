<?php

namespace drupol\phpartition;

/**
 * Class PartitionItem.
 *
 * @package drupol\phpartition
 */
class PartitionItem implements PartitionItemInterface {

  protected $item;
  protected $valueOrCallable;

  /**
   * PartitionItem constructor.
   *
   * @param mixed $item
   *   The item.
   * @param float|callable $valueOrCallable
   *   A callable that will get it's value or a value.
   */
  public function __construct($item, $valueOrCallable = NULL) {
    $this->item = $item;
    $this->valueOrCallable = $valueOrCallable;
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    if (is_callable($this->valueOrCallable)) {
      return call_user_func($this->valueOrCallable, $this->item);
    }

    if (!is_null($this->valueOrCallable)) {
      return $this->valueOrCallable;
    }

    return is_numeric($this->item) ? $this->item : 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getItem() {
    return $this->item;
  }

}

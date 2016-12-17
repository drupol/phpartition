<?php

namespace drupol\phpartition;

/**
 * Class SubsetItem.
 *
 * @package drupol\phpartition
 */
class SubsetItem {

  protected $key;
  protected $value;
  protected $item;

  /**
   * SubsetItem constructor.
   *
   * @param $key
   * @param $value
   * @param $item
   */
  public function __construct($key, $value, $item) {
    $this->key = $key;
    $this->value = $value;
    $this->item = $item;
  }

  /**
   * @return mixed
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @return mixed
   */
  public function getKey(){
    return $this->key;
  }

  /**
   * @return mixed
   */
  public function getItem() {
    return $this->item;
  }

}
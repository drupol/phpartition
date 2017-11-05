<?php

namespace drupol\phpartition;

/**
 * Interface PartitionItemInterface.
 *
 * @package drupol\phpartition
 */
interface PartitionItemInterface
{

  /**
   * Get the original item.
   *
   * @return mixed
   *   The original item.
   */
    public function getItem();

    /**
     * Get the value of the item.
     *
     * @return int|float
     *   The value of the item.
     */
    public function getValue();
}

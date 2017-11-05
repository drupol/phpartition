<?php

namespace drupol\phpartition;

use phootwork\collection\Map;

/**
 * Class Partition.
 *
 * @package drupol\phpartition
 */
class Partition extends Map
{

  /**
   * The algorithm in use.
   *
   * @var PartitionAlgorithmInterface
   */
    protected $algo;

    /**
     * Partition constructor.
     *
     * @param PartitionItem[] $elements
     *   The list of elements.
     */
    public function __construct(array $elements = [])
    {
        parent::__construct([]);
        $this->addItems($elements);
    }

    /**
     * Add an item to the partition.
     *
     * @param PartitionItem $item
     *   The item to add to the partition.
     *
     * @return $this
     *   Return itself.
     */
    public function addItem(PartitionItem $item)
    {
        $this->set(spl_object_hash($item), $item);

        return $this;
    }

    /**
     * Add items to the partition.
     *
     * @param PartitionItem[] $items
     *   The items to add to the partition.
     *
     * @return $this
     *   Return itself.
     */
    public function addItems(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * Get an array of original items.
     *
     * @return array
     *   The original items.
     */
    public function getRawItems()
    {
        return array_values(
            array_map(function ($item) {
                return $item->getItem();
            }, $this->toArray())
        );
    }

    /**
     * Get the weight of the partition.
     *
     * @return int
     *   The partition's weight.
     */
    public function getWeight()
    {
        return array_reduce($this->toArray(), function ($sum, $item) {
            $sum += $item->getValue();
            return $sum;
        });
    }

    /**
     * Set the algorithm to use.
     *
     * @param BasePartitionAlgorithm $algo
     *   The algorithm to use.
     */
    public function setAlgo(BasePartitionAlgorithm $algo)
    {
        $this->algo = $algo;
    }

    /**
     * Get the algorithm in use.
     *
     * @return PartitionAlgorithmInterface
     *   The algorithm in use.
     */
    public function getAlgo()
    {
        return $this->algo;
    }

    /**
     * Delete items from the partition.
     *
     * @param PartitionItem[] $items
     *   The items to delete.
     */
    public function deleteItems(array $items = [])
    {
        foreach ($items as $item) {
            $this->delete($item);
        }
    }

    /**
     * Delete an item from the partition.
     *
     * @param PartitionItem $item
     *   The item to delete.
     */
    public function delete(PartitionItem $item)
    {
        $this->remove(spl_object_hash($item));
    }

    /**
     * Sort the items of the partition in a particular order.
     *
     * @param string $order
     *   ASC for ascending, DESC for descending.
     *
     * @return $this
     */
    public function sortByValue($order = 'ASC')
    {
        if ('ASC' == $order) {
            $this->sort(function ($itemA, $itemB) {
                return $itemA->getValue() > $itemB->getValue();
            });
        }

        if ('DESC' == $order) {
            $this->sort(function ($itemA, $itemB) {
                return $itemA->getValue() < $itemB->getValue();
            });
        }

        return $this;
    }
}

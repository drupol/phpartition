<?php

declare(strict_types = 1);

namespace drupol\phpartition\Partition;

use drupol\phpartition\Contract\Valuable;
use drupol\phpartition\Contract\PartitionItem as PartitionItemInterface;
use drupol\phpartition\Contract\Partition as PartitionInterface;

/**
 * Class Partition.
 */
class Partition extends \ArrayObject implements PartitionInterface
{
    /**
     * @return array
     */
    public function exportArrayCopy()
    {
        return \array_map(
            static function (Valuable $item) {
                return $item->getValue();
            },
            $this->getArrayCopy()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBounds(): array
    {
        $max = PHP_INT_MAX;
        $min = PHP_INT_MIN;

        $bounds = [];

        foreach ($this as $index => $item) {
            if ($item instanceof PartitionItemInterface) {
                $item = $item->getWeight();
            }

            if ($item < $max) {
                $max = $item;
                $bounds[0] = $index;
            }

            if ($item > $min) {
                $min = $item;
                $bounds[1] = $index;
            }
        }

        return $bounds;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight(): float
    {
        $weight = 0;

        foreach ($this as $item) {
            if ($item instanceof PartitionItemInterface) {
                $item = $item->getWeight();
            }

            $weight += $item;
        }

        return $weight;
    }
}

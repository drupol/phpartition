<?php

declare(strict_types=1);

namespace drupol\phpartition;

use drupol\phpartition\Contract\PartitionItem;
use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class Greedy.
 */
class Greedy extends Partitioner
{
    /**
     * @param \drupol\phpartition\Partitions\Partitions $partitions
     * @param \drupol\phpartition\Partition\Partition $dataset
     * @param int $chunks
     */
    protected function fillPartitions(Partitions $partitions, Partition $dataset, int $chunks): void
    {
        // Greedy needs a dataset sorted DESC.
        $dataset->uasort(
            static function (PartitionItem $left, PartitionItem $right) {
                return $right->getWeight() <=> $left->getWeight();
            }
        );

        foreach ($dataset as $data) {
            $partitions
                ->sort()
                ->partition(0)
                ->append($data);
        }
    }
}

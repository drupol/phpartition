<?php

declare(strict_types = 1);

namespace drupol\phpartition;

use drupol\phpartition\Contract\PartitionItem;
use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class Greedy.
 */
class GreedyAltAltAlt extends Partitioner
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

        $partitionsArray = [];
        $best = $dataset->getWeight() / $chunks;

        for ($p = 1; $p < $chunks; ++$p) {
            $partition = $this->getPartitionFactory()::create();

            \reset($dataset);
            $key = \key($dataset);
            $partition->append($dataset[$key]);
            unset($dataset[$key]);
            $dataset->exchangeArray(\array_values(\array_reverse($dataset->getArrayCopy())));

            while ($partition->getWeight() < $best) {
                \reset($dataset);
                $key = \key($dataset);
                $partition->append($dataset[$key]);
                unset($dataset[$key]);
            }

            $partitionsArray[] = $partition;

            $dataset->exchangeArray(\array_values(\array_reverse($dataset->getArrayCopy())));
        }

        $partitionsArray[] = $dataset;

        foreach ($partitionsArray as $key => $subset) {
            $partitions->partition($key)->exchangeArray($subset);
        }
    }
}

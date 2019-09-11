<?php

declare(strict_types=1);

namespace drupol\phpartition;

use drupol\phpartition\Contract\PartitionItem;
use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class GreedyAltAlt.
 */
class GreedyAltAlt extends Partitioner
{
    /**
     * {@inheritdoc}
     */
    protected function fillPartitions(Partitions $partitions, Partition $dataset, int $chunks): void
    {
        // Edge case handling.
        if ($dataset->count() === $chunks) {
            foreach ($dataset as $key => $item) {
                $partitions->partition((int) $key)->exchangeArray([$item]);
            }

            return;
        }

        // Edge case handling.
        if (0 === $chunks) {
            throw new \InvalidArgumentException('Chunks must be different from 0.');
        }

        // Greedy needs a dataset sorted DESC.
        $dataset->uasort(
            static function (PartitionItem $left, PartitionItem $right) {
                return $left->getWeight() <=> $right->getWeight();
            }
        );

        $partitionsArray = [];
        $best = $dataset->getWeight() / $chunks;

        for ($p = 1; $p < $chunks; ++$p) {
            $partition = $this->getPartitionFactory()::create();

            while ($partition->getWeight() < $best && 1 < $dataset->count()) {
                $bounds = $dataset->getBounds();
                // Get the key of the item with the lowest value.
                $key = $bounds[0];

                if (0 === $partition->count()) {
                    // Get the key of the item with the highest value.
                    $key = $bounds[1];
                }

                $partition->append($dataset[$key]);
                unset($dataset[$key]);
                $dataset->exchangeArray(\array_values($dataset->getArrayCopy()));
            }

            $partitionsArray[] = $partition;
        }

        $partitionsArray[] = $dataset;

        foreach ($partitionsArray as $key => $subset) {
            $partitions->partition($key)->exchangeArray($subset);
        }
    }
}

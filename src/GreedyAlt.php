<?php

declare(strict_types = 1);

namespace drupol\phpartition;

use drupol\phpartition\Contract\PartitionItem;
use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class GreedyAlt.
 */
class GreedyAlt extends Partitioner
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
                return $right->getWeight() <=> $left->getWeight();
            }
        );

        $best = $dataset->getWeight() / $chunks;

        for ($p = 1; $p < $chunks; ++$p) {
            $partition = $partitions->partition($p - 1);

            while ($partition->getWeight() < $best && 1 < $dataset->count()) {
                $key = $this->findOptimalItemKey($partition, $dataset, $best);
                $partition->append($dataset[$key]);
                unset($dataset[$key]);
            }
        }

        $partitions->partition($p - 1)->exchangeArray($dataset);
    }

    /**
     * @param \drupol\phpartition\Partition\Partition $partition
     * @param \drupol\phpartition\Partition\Partition $dataset
     * @param float $best
     *
     * @return null|false|int|string
     */
    private function findOptimalItemKey(Partition $partition, Partition $dataset, $best)
    {
        // If the current partition is empty, then use the highest value of the
        // dataset.
        if (0 === $partition->count()) {
            // As the dataset is sorted DESC, return the highest value.
            return \key($dataset);
        }

        // Find which number in the $dataset would be the best fit by checking
        // which one is closer to the best solution.
        // Best solution is the sum of the dataset values divided by the number
        // of chunks we want to have.
        $partitionWeightMinusBest = $partition->getWeight() - $best;

        $solutions = \array_map(
            static function (PartitionItem $item) use ($partitionWeightMinusBest) {
                return \abs($partitionWeightMinusBest + $item->getWeight());
            },
            \iterator_to_array($dataset)
        );

        \asort($solutions);

        return \key($solutions);
    }
}

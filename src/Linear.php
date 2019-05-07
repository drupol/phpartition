<?php

declare(strict_types = 1);

namespace drupol\phpartition;

use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class Linear.
 */
class Linear extends Partitioner
{
    /**
     * @param \drupol\phpartition\Partitions\Partitions $partitions
     * @param \drupol\phpartition\Partition\Partition $dataset
     * @param int $chunks
     */
    protected function fillPartitions(Partitions $partitions, Partition $dataset, int $chunks): void
    {
        $dataset = $dataset->getArrayCopy();

        // See https://github.com/technically-php/linear-partitioning for
        // original version of this algorithm.

        // An array S of non-negative numbers {s1, ... ,sn}
        $s = \array_merge([null], $dataset); // adapt indices here: [0..n-1] => [1..n]

        // Integer K - number of ranges to split items into
        $k = $chunks;
        $n = \count($dataset);

        // Let D[n,k] be the position of K-th divider
        // which produces the minimum possible cost partitioning of N elements to K ranges
        $d = [];

        // Let p be the sum of first i elements (cost calculation optimization)
        $p = [];

        // 1) Init prefix sums array
        //    pi = sum of {s1, ..., si}
        $p[0] = $this->getPartitionItemFactory()::create(0);
        for ($i = 1; $i <= $n; ++$i) {
            $p[$i] = $this->getPartitionItemFactory()::create($p[$i - 1]->getWeight() + $s[$i]->getWeight());
        }

        // Let M[n,k] be the minimum possible cost over all partitionings of N elements to K ranges
        $m = [];

        // 2) Init boundaries
        for ($i = 1; $i <= $n; ++$i) {
            // The only possible partitioning of i elements to 1 range is a single all-elements range
            // The cost of that partitioning is the sum of those i elements
            $m[$i][1] = $p[$i]; // sum of {s1, ..., si} -- optimized using pi
        }

        for ($j = 1; $j <= $k; ++$j) {
            // The only possible partitioning of 1 element into j ranges is a single one-element range
            // The cost of that partitioning is the value of first element
            $m[1][$j] = $s[1];
        }
        // 3) Main recurrence (fill the rest of values in table M)
        for ($i = 2; $i <= $n; ++$i) {
            for ($j = 2; $j <= $k; ++$j) {
                $solutions = [];
                for ($x = 1; ($i - 1) >= $x; ++$x) {
                    $solutions[] = [
                        0 => $this->getPartitionItemFactory()::create(
                            \max(
                                $m[$x][$j - 1]->getWeight(),
                                $p[$i]->getWeight() - $p[$x]->getWeight()
                            )
                        ),
                        1 => $x,
                    ];
                }

                \usort(
                    $solutions,
                    static function (array $x, array $y) {
                        return $x[0] <=> $y[0];
                    }
                );

                $best_solution = $solutions[0];
                $m[$i][$j] = $best_solution[0];
                $d[$i][$j] = $best_solution[1];
            }
        }

        // 4) Reconstruct partitioning
        $i = $n;
        $j = $k;
        $partition = [];
        while (0 < $j) {
            // delimiter position
            $dp = $d[$i][$j] ?? 0;
            // Add elements after delimiter {sdp, ..., si} to resulting $partition.
            $partition[] = \array_slice($s, $dp + 1, $i - $dp);
            // Step forward: look for delimiter position for partitioning M[$dp, $j-1]
            $i = $dp;
            --$j;
        }

        foreach ($partition as $i => $p) {
            $partitions->partition($i)->exchangeArray($p);
        }
    }
}

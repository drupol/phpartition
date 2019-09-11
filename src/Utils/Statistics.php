<?php

declare(strict_types=1);

namespace drupol\phpartition\Utils;

use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;

/**
 * Class Statistics.
 */
class Statistics
{
    /**
     * @param \drupol\phpartition\Partition\Partition $partition
     *
     * @return float|int
     */
    public static function meanPartition(Partition $partition)
    {
        return $partition->getWeight() / $partition->count();
    }

    /**
     * @param \drupol\phpartition\Partition\Partition $partition
     *
     * @return float
     */
    public static function standardDeviationPartition(Partition $partition)
    {
        $mean = self::meanPartition($partition);

        $sumSquareDiff = \array_sum(\array_map(
            static function ($sum) use ($mean) {
                return ($sum - $mean) ** 2;
            },
            $partition->getArrayCopy()
        ));

        return ($sumSquareDiff / $partition->count()) ** .5;
    }

    /**
     * @param \drupol\phpartition\Partitions\Partitions $partitions
     *
     * @return float
     */
    public static function standardDeviationPartitions(Partitions $partitions)
    {
        $partition = new Partition(
            \array_map(
                static function (Partition $partition) {
                    return $partition->getWeight();
                },
                $partitions->partitions()
            )
        );

        return self::standardDeviationPartition($partition);
    }
}

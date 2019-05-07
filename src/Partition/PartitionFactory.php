<?php

declare(strict_types = 1);

namespace drupol\phpartition\Partition;

class PartitionFactory
{
    /**
     * @return \drupol\phpartition\Partition\Partition
     */
    public static function create()
    {
        return new Partition();
    }
}

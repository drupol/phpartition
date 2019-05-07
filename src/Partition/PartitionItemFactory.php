<?php

declare(strict_types = 1);

namespace drupol\phpartition\Partition;

use drupol\phpartition\Contract\PartitionItem as PartitionItemInterface;

/**
 * Class PartitionItemFactory.
 */
class PartitionItemFactory
{
    public static function create($value): PartitionItemInterface
    {
        if ($value instanceof PartitionItemInterface) {
            return $value;
        }

        return new PartitionItem($value);
    }
}

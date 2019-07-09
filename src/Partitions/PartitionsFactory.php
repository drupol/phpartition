<?php

declare(strict_types = 1);

namespace drupol\phpartition\Partitions;

class PartitionsFactory
{
    public static function create(int $size)
    {
        return new Partitions($size);
    }
}

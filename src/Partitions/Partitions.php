<?php

declare(strict_types=1);

namespace drupol\phpartition\Partitions;

use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partition\PartitionFactory;

class Partitions implements \Countable
{
    /**
     * @var array
     */
    private $storage;

    /**
     * Partitions constructor.
     *
     * @param int $size
     * @param \drupol\phpartition\Partition\PartitionFactory $partitionFactory
     */
    public function __construct(int $size, PartitionFactory $partitionFactory = null)
    {
        $this->storage['size'] = $size;
        $partitionFactory = $partitionFactory ?? new PartitionFactory();

        for ($i = 0; $i < $size; ++$i) {
            $this->storage['partitions'][$i] = $partitionFactory::create();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return \count($this->storage['partitions']);
    }

    /**
     * @param int $index
     *
     * @return \drupol\phpartition\Partition\Partition
     */
    public function partition(int $index)
    {
        return $this->storage['partitions'][$index];
    }

    /**
     * @return \drupol\phpartition\Partition\Partition[]
     */
    public function partitions()
    {
        return $this->storage['partitions'];
    }

    /**
     * @param null|callable $compareCallable
     *
     * @return \drupol\phpartition\Partitions\Partitions
     */
    public function sort(callable $compareCallable = null)
    {
        if (null === $compareCallable) {
            $compareCallable = static function (Partition $item1, Partition $item2) {
                return $item1->getWeight() <=> $item2->getWeight();
            };
        }

        \usort($this->storage['partitions'], $compareCallable);

        return $this;
    }
}

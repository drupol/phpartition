<?php

declare(strict_types=1);

namespace drupol\phpartition;

use drupol\phpartition\Contract\PartitionerInterface;
use drupol\phpartition\Contract\Weightable;
use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partition\PartitionFactory;
use drupol\phpartition\Partition\PartitionItemFactory;
use drupol\phpartition\Partitions\Partitions;
use drupol\phpartition\Partitions\PartitionsFactory;

/**
 * Class Partitioner.
 */
abstract class Partitioner implements PartitionerInterface
{
    /**
     * @var iterable
     */
    private $dataset;

    /**
     * @var \drupol\phpartition\Partitions\Partitions
     */
    private $lastRun;

    /**
     * @var PartitionFactory
     */
    private $partitionFactory;

    /**
     * @var PartitionItemFactory
     */
    private $partitionItemFactory;

    /**
     * @var PartitionsFactory
     */
    private $partitionsFactory;

    /**
     * {@inheritdoc}
     */
    final public function export(int $chunks = 1)
    {
        return \array_map(
            static function (Partition $partition) {
                return \array_values($partition->exportArrayCopy());
            },
            $this
                ->run($chunks)
                ->getLastRun()
                ->partitions()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * @return \drupol\phpartition\Partition\Partition
     */
    final public function getDatasetPartition()
    {
        $partition = $this->getPartitionFactory()::create();

        foreach ($this->getDataset() as $data) {
            $partition->append($this->toPartitionItem($data));
        }

        return $partition;
    }

    /**
     * @return \drupol\phpartition\Partitions\Partitions
     */
    final public function getLastRun()
    {
        return $this->lastRun;
    }

    /**
     * @return \drupol\phpartition\Partition\PartitionFactory
     */
    public function getPartitionFactory()
    {
        return $this->partitionFactory ?? new PartitionFactory();
    }

    /**
     * @return \drupol\phpartition\Partition\PartitionItemFactory
     */
    public function getPartitionItemFactory()
    {
        return $this->partitionItemFactory ?? new PartitionItemFactory();
    }

    /**
     * @return \drupol\phpartition\Partitions\PartitionsFactory
     */
    public function getPartitionsFactory()
    {
        return $this->partitionsFactory ?? new PartitionsFactory();
    }

    /**
     * {@inheritdoc}
     */
    final public function run(int $chunks = 1)
    {
        $partitions = $this->getPartitionsFactory()::create($chunks);

        $dataPartition = $this->getDatasetPartition();

        $this->fillPartitions($partitions, $dataPartition, $chunks);

        $this->lastRun = $partitions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    final public function setDataset(iterable $dataset)
    {
        $this->dataset = $dataset;

        return $this;
    }

    /**
     * @param mixed $originalItem
     *
     * @return \drupol\phpartition\Contract\Weightable
     */
    public function toPartitionItem($originalItem): Weightable
    {
        return $this->getPartitionItemFactory()::create($originalItem);
    }

    /**
     * @param \drupol\phpartition\Partitions\Partitions $partitions
     * @param Partition $dataset
     * @param int $chunks
     */
    abstract protected function fillPartitions(Partitions $partitions, Partition $dataset, int $chunks): void;
}

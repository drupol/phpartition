<?php

declare(strict_types=1);

namespace drupol\phpartition\Contract;

interface PartitionerInterface
{
    /**
     * @param int $chunks
     *
     * @return array
     */
    public function export(int $chunks);

    /**
     * @return iterable
     */
    public function getDataset();

    /**
     * @return \drupol\phpartition\Partition\Partition
     */
    public function getDatasetPartition();

    /**
     * @return \drupol\phpartition\Partitions\Partitions
     */
    public function getLastRun();

    /**
     * @param int $chunks
     *
     * @return \drupol\phpartition\Contract\PartitionerInterface
     */
    public function run(int $chunks);

    /**
     * @param iterable $dataset
     *
     * @return \drupol\phpartition\Contract\PartitionerInterface
     */
    public function setDataset(iterable $dataset);
}

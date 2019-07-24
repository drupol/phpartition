<?php

declare(strict_types = 1);

namespace drupol\phpartition;

use drupol\phpartition\Partition\Partition;
use drupol\phpartition\Partitions\Partitions;
use drupol\phpermutations\Generators\Combinations as CombinationsGenerator;

/**
 * Class Combinations.
 */
class Combinations extends Partitioner
{
    /**
     * @var int
     */
    private $timeout;

    /**
     * Linear constructor.
     *
     * @param int $timeout
     *
     * @throws \Exception
     */
    public function __construct(int $timeout = 10)
    {
        if (!class_exists(CombinationsGenerator::class)) {
            throw new \Exception(
                sprintf(
                    'The class %s is not available, run "%s" to get it.',
                    '\drupol\phpermutations\Generators\Combinations',
                    'composer require drupol/phpermutations'
                )
            );
        }

        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     *
     * @return $this
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function fillPartitions(Partitions $partitions, Partition $dataset, int $chunks): void
    {
        $partition = new Partition($dataset);
        $partition->uasort(static function ($left, $right) {
            return $left->getWeight() <=> $right->getWeight();
        });
        $dataset = $partition->getArrayCopy();

        for ($p = $chunks; 1 < $p; --$p) {
            $partition = new Partition($dataset);

            $best = $partition->getWeight();
            $target = $best / $p;
            $maxSize = floor($partition->count() / $p);

            $goodSubset = $this->getSubsets($maxSize, $dataset, $target, $best);

            // We cannot use array_udiff() to compare objects because we only need
            // to remove one object at a time.
            foreach ($goodSubset as $item) {
                if (false !== $key = array_search($item, $dataset, true)) {
                    unset($dataset[$key]);
                }
            }

            if (!empty($goodSubset)) {
                $partitionsArray[] = $goodSubset;
            }
        }

        $partitionsArray[] = $dataset;

        foreach ($partitionsArray as $key => $subset) {
            $partitions->partition($key)->exchangeArray($subset);
        }
    }

    /**
     * @param float $maxSize
     * @param array $dataset
     * @param float $target
     * @param float $best
     *
     * @return array
     */
    private function getSubsets($maxSize, $dataset, $target, $best)
    {
        $start_time = time();
        $goodSubsets = $dataset;
        $timeout = $this->getTimeout();

        for ($i = 1; $i <= $maxSize; ++$i) {
            $permutations = new CombinationsGenerator($dataset, $i);

            foreach ($permutations->generator() as $subset) {
                if (time() - $start_time > $timeout) {
                    return $goodSubsets;
                }

                $x = 0;

                foreach ($subset as $item) {
                    $x += $item->getWeight();

                    if (abs($x - $target) < abs($best - $target)) {
                        $best = $x;
                        $goodSubsets = $subset;
                    }
                }
            }
        }

        return $goodSubsets;
    }
}

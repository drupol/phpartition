<?php

declare(strict_types=1);

namespace drupol\phpartition\Partition;

use drupol\phpartition\Contract\PartitionItem as PartitionItemInterface;

/**
 * Class PartitionItem.
 */
class PartitionItem implements PartitionItemInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * PartitionItem constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight(): float
    {
        return $this->value;
    }
}

<?php

declare(strict_types = 1);

namespace drupol\phpartition\Contract;

interface Weightable
{
    /**
     * @return float
     */
    public function getWeight(): float;
}

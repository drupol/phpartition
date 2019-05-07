<?php

declare(strict_types = 1);

namespace drupol\phpartition\Contract;

interface Valuable
{
    /**
     * @return mixed
     */
    public function getValue();
}

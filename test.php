<?php

/**
 * @file
 */

use drupol\phpartition\Algorithm\Greedy;
use drupol\phpartition\PartitionItem;

require "vendor/autoload.php";

$a = new StdClass();
$a->id = 'a';

$b = new StdClass();
$b->id = 'b';

$input = [1, new PartitionItem($a, 2), new PartitionItem($b, 3), 4];

$simple = new Greedy();
$simple->setSize(2);
$simple->setData($input);

print_r($simple->getResult());

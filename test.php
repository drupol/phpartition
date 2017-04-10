<?php

/**
 * @file
 */

use drupol\phpartition\Algorithm\Greedy;

require "vendor/autoload.php";

$input = [];
foreach (range(1, 10) as $iter) {
    $input[] = rand(1, $iter);
}

sort($input);

echo "input = [" . implode(',', $input) . "]\n\n";

/** @var \drupol\phpartition\PartitionAlgorithmInterface[] $algos */
$algos = [
  new \drupol\phpartition\Algorithm\Simple(),
  new Greedy(),
  new \drupol\phpartition\Algorithm\BruteForce(),
  new \drupol\phpartition\Algorithm\BruteForceCustomA()
];

foreach ($algos as $algo) {
    $start_time = microtime(true);

    echo "\n";
    echo "******************************************************\n";
    echo "* Type: " . get_class($algo) . "\n";
    echo "******************************************************\n\n";
    $algo->setSize(3);
    $algo->setData($input);

    $sums = [];
    foreach ($algo->getResult() as $subset) {
        sort($subset);
        $sum = array_sum($subset);
        $sums[] = $sum;
        echo "[" . implode(',', $subset) . "] = " . $sum . "\n";
    }

    $stdDev = \Oefenweb\Statistics\Statistics::standardDeviation($sums);
    echo "Variance: " . round($stdDev, 1) . "\n";

    $end = microtime(true) - $start_time;

    echo "\nTime elapsed: " . $end . "\n";
}

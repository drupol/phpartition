<?php

namespace drupol\phpartition\Tests;

use drupol\phpartition\Algorithm\Greedy;
use drupol\phpartition\PartitionItem;

/**
 * Class GreedyTest.
 *
 * @package drupol\phpartition\Tests
 */
class GreedyTest extends PhpPartitionTestBase {

  /**
   * Test the algorithm.
   *
   * @dataProvider simpleValueProvider
   */
  public function testGreedy($input, $output) {
    $algo = new Greedy();
    $algo->setSize($input['partition']);
    $this->assertEquals($input['partition'], $algo->getSize());

    $algo->setData($input['data']);
    $this->assertEquals($input['data'], $algo->getData());

    if (isset($input['callback'])) {
      $algo->setItemAccessCallback($input['callback']);
    }

    $this->assertEquals($output, $algo->getResult());
  }

  /**
   * Value provider.
   */
  public function simpleValueProvider() {
    $a = new \StdClass();
    $a->id = 'a';

    $b = new \StdClass();
    $b->id = 'b';

    return [
      [
        'input' => [
          'data' => [1, new PartitionItem($a, 2), new PartitionItem($b, 3), 4],
          'partition' => 2,
        ],
        'output' => [
          [$b, $a],
          [4, 1],
        ],
      ],
      [
        'input' => [
          'data' => [1, 2, 3, 4],
          'partition' => 2,
        ],
        'output' => [
          [3, 2],
          [4, 1],
        ],
      ],
      [
        'input' => [
          'data' => [
            ['key' => 'item1', 'weight' => 1],
            ['key' => 'item2', 'weight' => 2],
            ['key' => 'item3', 'weight' => 3],
            ['key' => 'item4', 'weight' => 4],
          ],
          'partition' => 2,
          'callback' => function ($item) {
            return $item['weight'];
          },
        ],
        'output' => [
          [['key' => 'item3', 'weight' => 3], ['key' => 'item2', 'weight' => 2]],
          [['key' => 'item4', 'weight' => 4], ['key' => 'item1', 'weight' => 1]],
        ],
      ],
    ];
  }

}

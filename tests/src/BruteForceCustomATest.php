<?php

namespace drupol\phpartition\Tests;

use drupol\phpartition\Algorithm\BruteForceCustomA;
use drupol\phpartition\PartitionItem;

/**
 * Class BruteForceCustomATest.
 *
 * @package drupol\phpartition\Tests
 */
class BruteForceCustomATest extends PhpPartitionTestBase
{

  /**
   * Test the algorithm.
   *
   * @dataProvider simpleValueProvider
   */
    public function testBruteForce($input, $output)
    {
        $algo = new BruteForceCustomA();
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
    public function simpleValueProvider()
    {
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
          [1, 4],
          [$a, $b],
        ],
        ],
      [
        'input' => [
          'data' => [1, 2, 3, 4],
          'partition' => 4,
        ],
        'output' => [
          [1], [4], [2], [3],
        ],
        ],
        [
        'input' => [
          'data' => [1, 2, 3, 4],
          'partition' => 5,
        ],
        'output' => [
          [3], [4], [1], [2],
        ],
        ],
        [
        'input' => [
          'data' => [1, 2, 3, 4],
          'partition' => 2,
        ],
        'output' => [
          [1, 4],
          [2, 3],
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
          [['key' => 'item1', 'weight' => 1], ['key' => 'item4', 'weight' => 4]],
          [['key' => 'item2', 'weight' => 2], ['key' => 'item3', 'weight' => 3]],
        ],
        ],
        ];
    }
}

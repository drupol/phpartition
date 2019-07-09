<?php

declare(strict_types = 1);

namespace drupol\phpartition\Tests\unit;

use Codeception\Test\Unit;
use drupol\phpartition\GreedyAltAlt;

/**
 * @internal
 *
 * @covers \drupol\phpartition\GreedyAltAlt
 * @covers \drupol\phpartition\Partitioner
 */
final class GreedyAltAltTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function greedyAltAltTestProvider()
    {
        yield [
            [1, 2, 3, 4, 5, 6],
            1,
            [[1, 2, 3, 4, 5, 6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [[6, 1, 2, 3], [4, 5]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            3,
            [[6, 1], [5, 2], [3, 4]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            4,
            [[6], [5, 1], [4, 2], [3]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            5,
            [[6], [5], [4, 1], [3], [2]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            6,
            [[1], [2], [3], [4], [5], [6]],
        ];
    }

    /**
     * @param $dataset
     * @param $chunks
     * @param $expected
     *
     * @dataProvider greedyAltAltTestProvider
     */
    public function testGreedyAltAlt($dataset, $chunks, $expected)
    {
        $greedy = new GreedyAltAlt();

        $greedy->setDataset($dataset);

        static::assertSame($expected, $greedy->export($chunks));
    }
}

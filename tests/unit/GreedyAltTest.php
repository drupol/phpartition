<?php

declare(strict_types = 1);

namespace drupol\phpartition\Tests\unit;

use Codeception\Test\Unit;
use drupol\phpartition\GreedyAlt;

/**
 * @internal
 *
 * @covers \drupol\phpartition\GreedyAlt
 * @covers \drupol\phpartition\Partitioner
 */
final class GreedyAltTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function greedyAltTestProvider()
    {
        yield [
            [1, 2, 3, 4, 5, 6],
            1,
            [[6, 5, 4, 3, 2, 1]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [[6, 5], [4, 3, 2, 1]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            3,
            [[6, 1], [5, 2], [4, 3]],
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
     * @dataProvider greedyAltTestProvider
     */
    public function testGreedyAlt($dataset, $chunks, $expected): void
    {
        $greedy = new GreedyAlt();

        $greedy->setDataset($dataset);

        static::assertSame($expected, $greedy->export($chunks));
    }
}

<?php

declare(strict_types=1);

namespace drupol\phpartition\Tests\unit;

use Codeception\Test\Unit;
use drupol\phpartition\Greedy;

/**
 * @internal
 *
 * @covers \drupol\phpartition\Greedy
 * @covers \drupol\phpartition\Partitioner
 */
final class GreedyTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function greedyTestProvider()
    {
        yield [
            [1, 2, 3, 4, 5, 6],
            1,
            [[6, 5, 4, 3, 2, 1]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [[5, 4, 1], [6, 3, 2]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            3,
            [[6, 1], [5, 2], [4, 3]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            4,
            [[4, 1], [3, 2], [5], [6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            5,
            [[2, 1], [3], [4], [5], [6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            6,
            [[1], [2], [3], [4], [5], [6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            7,
            [[1], [], [2], [3], [4], [5], [6]],
        ];
    }

    /**
     * @param $dataset
     * @param $chunks
     * @param $expected
     *
     * @dataProvider greedyTestProvider
     */
    public function testGreedy($dataset, $chunks, $expected): void
    {
        $greedy = new Greedy();

        $greedy->setDataset($dataset);

        self::assertSame($expected, $greedy->export($chunks));
    }
}

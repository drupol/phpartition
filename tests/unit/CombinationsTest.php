<?php

declare(strict_types = 1);

namespace drupol\phpartition\Tests\unit;

use Codeception\Test\Unit;
use drupol\phpartition\Combinations;

/**
 * @internal
 *
 * @covers \drupol\phpartition\Combinations
 * @covers \drupol\phpartition\Partitioner
 */
final class CombinationsTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function combinationsTestProvider()
    {
        yield [
            [1, 2, 3, 4, 5, 6],
            1,
            [[1, 2, 3, 4, 5, 6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [[4, 6], [1, 2, 3, 5]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            3,
            [[1, 6], [2, 5], [3, 4]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            4,
            [[5], [6], [1, 4], [2, 3]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            5,
            [[4], [5], [3], [6], [1, 2]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            6,
            [[3], [4], [2], [5], [1], [6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            7,
            [[1, 2, 3, 4, 5, 6], [], [], [], [], [], []],
        ];
    }

    /**
     * @param $dataset
     * @param $chunks
     * @param $expected
     *
     * @dataProvider combinationsTestProvider
     */
    public function testCombinations($dataset, $chunks, $expected): void
    {
        $anytime = new Combinations();

        $anytime->setDataset($dataset);

        static::assertSame($expected, $anytime->export($chunks));
    }
}

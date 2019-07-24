<?php

declare(strict_types = 1);

namespace drupol\phpartition\Tests\unit;

use Codeception\Test\Unit;
use drupol\phpartition\Linear;

/**
 * @internal
 *
 * @covers \drupol\phpartition\Linear
 * @covers \drupol\phpartition\Partitioner
 */
final class LinearTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function linearTestProvider()
    {
        yield [
            [1, 2, 3, 4, 5, 6],
            1,
            [[1, 2, 3, 4, 5, 6]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            2,
            [[5, 6], [1, 2, 3, 4]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            3,
            [[6], [4, 5], [1, 2, 3]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            4,
            [[6], [5], [4], [1, 2, 3]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            5,
            [[6], [5], [4], [3], [1, 2]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            6,
            [[6], [5], [4], [3], [2], [1]],
        ];

        yield [
            [1, 2, 3, 4, 5, 6],
            7,
            [[6], [5], [4], [3], [2], [1], []],
        ];
    }

    /**
     * @param $dataset
     * @param $chunks
     * @param $expected
     *
     * @dataProvider linearTestProvider
     */
    public function testLinear($dataset, $chunks, $expected): void
    {
        $greedy = new Linear();

        $greedy->setDataset($dataset);

        static::assertSame($expected, $greedy->export($chunks));
    }
}

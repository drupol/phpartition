<?php

declare(strict_types = 1);

namespace drupol\phpartition\Tests\unit\Partition;

use Codeception\Test\Unit;
use drupol\phpartition\Partition\Partition;

/**
 * @internal
 *
 * @covers \drupol\phpartition\Partition\PartitionItem
 */
final class PartitionTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @dataProvider testGetBoundsProvider
     *
     * @param mixed $input
     * @param mixed $expected
     */
    public function testGetBounds($input, $expected): void
    {
        $partition = new Partition($input);

        static::assertSame($expected, $partition->getBounds());
    }

    public function testGetBoundsProvider()
    {
        yield [
            [4, 5, 6, 7, 8],
            [0, 4],
        ];

        yield [
            [8, 5, 6, 7, 4],
            [4, 0],
        ];

        yield [
            [5, 4, 6, 8, 7],
            [1, 3],
        ];
    }
}

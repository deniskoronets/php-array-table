<?php

use dekor\ArrayToTextTable;
use dekor\ArrayToTextTableException;
use dekor\formatters\AlignFormatter;
use dekor\formatters\ColorFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers dekor\formatters\ColorFormatter
 */
final class ColorTest extends TestCase
{
    /**
     * @dataProvider getCases
     *
     * @param mixed $data
     * @param mixed $expectResult
     */
    public function testCorrectBuilding($data, $expectResult)
    {
        $builder = new ArrayToTextTable($data);
        $builder->applyFormatter(new ColorFormatter(['test' => fn ($value) => $value > 0 ? 'Red' : 'Green']));

        static::assertSame($expectResult, $builder->render());
    }

    public static function getCases()
    {
        return [
            [
                'data' => [
                    ['test' => 1],
                    ['test' => -1],
                ],
                'expected' =>
                    '+------+' . PHP_EOL .
                    '| test |' . PHP_EOL .
                    '+------+' . PHP_EOL .
                    '|[0;31m 1    [0m|' . PHP_EOL .
                    '|[0;32m -1   [0m|' . PHP_EOL .
                    '+------+',
            ],
        ];
    }

    public function testInCorrectBuilding()
    {
        $data = [['test' => 1]];

        $builder = new ArrayToTextTable($data);
        $builder->applyFormatter(new AlignFormatter(['test' => 'imposible']));

        $this->expectException(ArrayToTextTableException::class);
        $builder->render();
    }
}

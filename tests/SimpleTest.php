<?php

use PHPUnit\Framework\TestCase;
use dekor\ArrayToTextTable;

include __DIR__ . '/../src/ArrayToTextTable.php';

class SimpleTest extends TestCase
{
    /**
     * @dataProvider getCases
     */
    public function testCorrectBuilding($data, $expectResult)
    {
        $builder = new ArrayToTextTable($data);

        $this->assertEquals($expectResult, $builder->render());
    }

    /**
     * @dataProvider getFormattingCases
     */
    public function testFormatting($data, $format, $expectResult)
    {
        $builder = new ArrayToTextTable($data, $format);

        $this->assertEquals($expectResult, $builder->render());
    }

    public function getCases()
    {
        return [
            [
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Denis Koronets',
                        'role' => 'php developer',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Maxim Ambroskin',
                        'role' => 'java developer',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Andrew Sikorsky',
                        'role' => 'php developer',
                    ]
                ],
                'expected' =>
                    '+----+-----------------+----------------+' . PHP_EOL .
                    '| id | name            | role           |' . PHP_EOL .
                    '+----+-----------------+----------------+' . PHP_EOL .
                    '| 1  | Denis Koronets  | php developer  |' . PHP_EOL .
                    '| 2  | Maxim Ambroskin | java developer |' . PHP_EOL .
                    '| 3  | Andrew Sikorsky | php developer  |' . PHP_EOL .
                    '+----+-----------------+----------------+',
            ],
            [
                'data' => [
                    [
                        'singleColumn' => 'test value',
                    ],
                ],
                'expected' =>
                    '+--------------+' . PHP_EOL .
                    '| singleColumn |' . PHP_EOL .
                    '+--------------+' . PHP_EOL .
                    '| test value   |' . PHP_EOL .
                    '+--------------+',
            ],
            [
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Денис Коронец',
                        'role' => 'Тест кириллических символов',
                    ],
                ],
                'expected' =>
                    '+----+---------------+-----------------------------+' . PHP_EOL .
                    '| id | name          | role                        |' . PHP_EOL .
                    '+----+---------------+-----------------------------+' . PHP_EOL .
                    '| 1  | Денис Коронец | Тест кириллических символов |' . PHP_EOL .
                    '+----+---------------+-----------------------------+',
            ],
            [
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Денис Коронец',
                        'role' => 'Тест кириллических символов',
                    ],
                    '---',
                    [
                        'id' => 2,
                        'name' => 'Артем Малеев',
                        'role' => 'Тест кириллических символов 2',
                    ],
                ],
                'expected' =>
                    '+----+---------------+-------------------------------+' . PHP_EOL .
                    '| id | name          | role                          |' . PHP_EOL .
                    '+----+---------------+-------------------------------+' . PHP_EOL .
                    '| 1  | Денис Коронец | Тест кириллических символов   |' . PHP_EOL .
                    '+----+---------------+-------------------------------+' . PHP_EOL .
                    '| 2  | Артем Малеев  | Тест кириллических символов 2 |' . PHP_EOL .
                    '+----+---------------+-------------------------------+',
            ],
            [
                'data' => [
                    [
                        'sum' => 10.999,
                    ],
                    [
                        'sum' => 22,
                    ],
                    [
                        'sum' => 7,
                    ],
                    [
                        'sum' => 0,
                    ],
                ],
                'expected' =>
                    '+--------+' . PHP_EOL .
                    '| sum    |' . PHP_EOL .
                    '+--------+' . PHP_EOL .
                    '| 10.999 |' . PHP_EOL .
                    '| 22     |' . PHP_EOL .
                    '| 7      |' . PHP_EOL .
                    '| 0      |' . PHP_EOL .
                    '+--------+',
            ],
        ];
    }

    public function getFormattingCases()
    {
        return [
            [
                'data' => [
                    [
                        'sum' => 10.999,
                    ],
                    [
                        'sum' => 222,
                    ],
                    [
                        'sum' => 7,
                    ],
                    [
                        'sum' => 0,
                    ],
                ],
                'format' => [
                    'padding' => 'left',
                    'number' => '%.2f',
                ],
                'expected' =>
                    '+--------+' . PHP_EOL .
                    '|    sum |' . PHP_EOL .
                    '+--------+' . PHP_EOL .
                    '|  11.00 |' . PHP_EOL .
                    '| 222.00 |' . PHP_EOL .
                    '|   7.00 |' . PHP_EOL .
                    '|   0.00 |' . PHP_EOL .
                    '+--------+',
            ],
        ];
    }
}
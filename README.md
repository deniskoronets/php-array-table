# PHP Array To Text Table

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/badges/build.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/build-status/master)

PHP-class, which allows to transform php associative arrays to cool ASCII tables.

## Installation
Simply run composer require:
<pre>composer require dekor/php-array-table</pre>

or add to composer.json:
<pre>"dekor/php-array-table": "1.0"</pre>

## Usage

```php
use dekor\ArrayToTextTable;

$data = [
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
];

echo (new ArrayToTextTable($data))->render();
```

Will draw the next output:

```txt
+----+-----------------+----------------+
| id | name            | role           |
+----+-----------------+----------------+
| 1  | Denis Koronets  | php developer  |
| 2  | Maxim Ambroskin | java developer |
| 3  | Andrew Sikorsky | php developer  |
+----+-----------------+----------------+
```

Numbers can be formatted

```php
$data = [
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
];

$format = [
    'padding' => 'left',
    'number' => '%.2f',
];

echo (new ArrayToTextTable($data, $format))->render();
```

```txt
+--------+
|    sum |
+--------+
|  11.00 |
| 222.00 |
|   7.00 |
|   0.00 |
+--------+
```

<b>Made with ❤ by <a href="https://woo.zp.ua">denis</b>

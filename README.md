# PHP Array To Text Table

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/badges/build.png?b=master)](https://scrutinizer-ci.com/g/deniskoronets/php-array-table/build-status/master)

PHP-class, which allows to transform php associative arrays to cool ASCII tables.

## Installation
Simply run composer require:
<pre>composer require dekor/php-array-table</pre>

or add to composer.json:
<pre>"dekor/php-array-table": "^2.0"</pre>

## Usage
<pre>&lt;?php

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
</pre>

Will draw the next output:

<pre>
+----+-----------------+----------------+
| id | name            | role           |
+----+-----------------+----------------+
| 1  | Denis Koronets  | php developer  |
| 2  | Maxim Ambroskin | java developer |
| 3  | Andrew Sikorsky | php developer  |
+----+-----------------+----------------+
</pre>

## Formatters (since v2)
New feature introduces way to pre and postprocess column data by applying some filters.
List of such out of the box:
- `AlignFormatter` - allows to set text align for inner column (useful for numbers):

<pre>&lt;?php
$data = [
    [
        'left' => 2,
        'center' => 'Dummy one',
        'right' => 14.33,
    ],
    [
        'left' => 3,
        'center' => 'Another great day for a great inventers!',
        'right' => 1,
    ],
];

$builder = new ArrayToTextTable($data);
$builder->applyFormatter(new AlignFormatter(['center' => 'center', 'right' => 'right']));

echo $builder->render();
</pre>

outputs:
<pre>
+------+------------------------------------------+-------+
| left | center                                   | right |
+------+------------------------------------------+-------+
| 2    |                Dummy one                 | 14.33 |
| 3    | Another great day for a great inventers! |     1 |
+------+------------------------------------------+-------+
</pre>

- `SprintfFormatter` - allows to format column value before rendering using sprintf function (ex: %01.3f)
<pre>&lt;?php
$data = [
    [
        'left' => 1,
        'right' => 2.89,
    ]
];

$builder = new ArrayToTextTable($data);
$builder->applyFormatter(new SprintfFormatter(['left' => '%01.3f', 'right' => '%03.3f']));

echo $builder->render();
</pre>
outputs:
<pre>
+-------+-------+
| left  | right |
+-------+-------+
| 1.000 | 2.890 |
+-------+-------+
</pre>

- `ColorFormatter` - allows to highlight text with specific color (only works in terminal):
<pre>&lt;?php


</pre>
outputs:

![img.png](img.png)

Allowed colors list (see `ColorFormatter::$colors`)
- Black
- Dark Grey
- Red
- Light Red
- Green
- Light Green
- Brown
- Yellow
- Blue
- Light Blue
- Magenta
- Light Magenta
- Cyan
- Light Cyan
- Light Grey
- White

### Creds:
<b>Made with ❤ by <a href="https://woo.zp.ua">Denys</b>

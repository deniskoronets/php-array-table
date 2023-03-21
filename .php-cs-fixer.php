<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor/')
    ->in('.');

$fixer = (new PhpCsFixer\Config('', ''))
    ->setRules([
        '@PhpCsFixer' => true,
    ])
    ->setFinder($finder);

if (isset($GLOBALS['argv']) && in_array('--allow-risky=yes', $GLOBALS['argv'], true)) {
    echo 'Risky rules enabled' . PHP_EOL;

    $fixer
        ->setRules([
            '@PhpCsFixer:risky' => true,
        ]);
}

return $fixer;

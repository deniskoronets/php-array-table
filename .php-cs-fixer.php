<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor/')
    ->in('.');

$fixer = (new PhpCsFixer\Config('', ''))
    ->setRules([
        '@PhpCsFixer' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'global_namespace_import' => [
            'import_classes' => false,
            'import_constants' => false,
            'import_functions' => true,
        ],
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_no_empty_return' => false,
        'phpdoc_summary' => false,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'yoda_style' => false,
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

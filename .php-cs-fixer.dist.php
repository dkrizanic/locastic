<?php

$finder = (new PhpCsFixer\Finder())
    ->path([
        'src/',
        'tests/'
    ])
    ->in(__DIR__)
    ->exclude([
        'var',
        '_output',
        '_generated',
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'yoda_style' => false,
        'strict_param' => true,
        'phpdoc_to_return_type' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'method_chaining_indentation' => true,
    ])
    ->setFinder($finder)
;

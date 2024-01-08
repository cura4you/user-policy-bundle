<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['var', 'vendor'])
    ->in(__DIR__);


$config = new PhpCsFixer\Config();
return $config->setRules(
    [
        '@PSR12' => true,
        '@PHP82Migration' => true,
        'single_quote' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'global_namespace_import' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_empty_phpdoc' => true,
        'phpdoc_order' => ['order' => ['param', 'return', 'throws']],
        'phpdoc_separation' => true,
        'no_extra_blank_lines' => true,
        'declare_strict_types' => true,
    ]
)->setFinder($finder);

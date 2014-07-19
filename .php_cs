<?php

require_once __DIR__.'/src/Decoupling/Fixer/ShortArraySyntaxFixer.php';

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('README.md')
    ->notName('composer.*')
    ->notName('phpunit.xml')
    ->exclude('app')
    ->exclude('build')
    ->exclude('web/bundles')
    ->exclude('deps')
    ->in(__DIR__)
;

// Load a local config-file when existing
if (file_exists('local.php_cs')) {
    require 'local.php_cs';
}

return Symfony\CS\Config\Config::create()
    ->addCustomFixer(new Decoupling\Fixer\ShortArraySyntaxFixer)
    ->fixers(
        [
            'encoding',
            'linefeed',
            'indentation',
            'trailing_spaces',
            'object_operator',
            'phpdoc_params',
            'visibility',
            'short_tag',
            'php_closing_tag',
            'return',
            'extra_empty_lines',
            'braces',
            'lowercase_constants',
            'lowercase_keywords',
            'include',
            'function_declaration',
            'controls_spaces',
            'spaces_cast',
            'elseif',
            'eof_ending',
            'one_class_per_file',
            'unused_use',
            'short_array_syntax'
        ]
    )
    ->finder($finder)
;

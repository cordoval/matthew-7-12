<?php

require_once __DIR__.'/src/Cordoval/Fixer/ShortArraySyntaxFixer.php';

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('README.md')
    ->notName('CHANGELOG.md')
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('phpunit.xml*')
    ->notName('*.txt')
    ->exclude('app')
    ->exclude('bin')
    ->exclude('build')
    ->exclude('jmeter')
    ->exclude('nginx')
    ->exclude('vendor')
    ->exclude('web/bundles')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->set
    ->fixers(
        array(
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
        )
    )
    ->finder($finder)
;
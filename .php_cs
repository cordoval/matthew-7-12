<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('README.md')
    ->notName('composer.*')
    ->notName('phpunit.xml')
    ->exclude('app/cache')
    ->exclude('build')
    ->exclude('web/bundles')
    ->exclude('deps')
    ->in(__DIR__)
;

if (file_exists(__DIR__.'/local.php_cs')) {
    require __DIR__.'/local.php_cs';
}

return Symfony\CS\Config\Config::create()
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
            'short_array_syntax',
            'standardize_not_equal',
            'new_with_braces',
            'ordered_use',
            'default_values',
        ]
    )
    ->finder($finder)
;

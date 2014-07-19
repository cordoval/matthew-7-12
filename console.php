<?php

set_time_limit(0);

require_once __DIR__.'/deps/autoload.php';

use Aequasi\Environment\SymfonyEnvironment;
use Grace\AppKernel;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

$input = new ArgvInput();
$environment = new SymfonyEnvironment($input, 'APP_ENV', 'app.env');

if ($environment->isDebug()) {
    Debug::enable();
}

(new CliApplication(
        new AppKernel($environment->getType(), $environment->isDebug())
    )
)->run($input);

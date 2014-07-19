<?php

use Grace\AppKernel;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../../deps/autoload.php';

$kernel = new AppKernel('prod', false);
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request)->send();
$kernel->terminate($request, $response);

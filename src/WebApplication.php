<?php

namespace Grace;

use Aequasi\Environment\Environment;
use Symfony\Component\HttpFoundation\Request;

class WebApplication
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var AppKernel
     */
    protected $kernel;

    public function __construct()
    {
        $this->environment = new Environment('APP_ENV', 'app.env');
        $this->buildRequest();
        $this->buildKernel();
    }

    private function buildRequest()
    {
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $_SERVER['REMOTE_ADDR'] = '207.7.117.122';
        }
        Request::enableHttpMethodParameterOverride();
        $this->request = Request::createFromGlobals();
    }

    private function buildKernel()
    {
        $this->kernel = new AppKernel($this->environment->getType(), $this->environment->isDebug());
    }

    public function run()
    {
        $response = $this->kernel->handle($this->request);
        $response->send();
        $this->kernel->terminate($this->request, $response);
    }
}

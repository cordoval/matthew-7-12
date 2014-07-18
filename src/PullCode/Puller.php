<?php

namespace Grace\PullCode;

use Grace\Domain\Container;
use Grace\Domain\Repo;

class Puller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Repo $repo)
    {
        $this->container->gitClone($repo);
        $this->container->checkout($repo, $repo->getHookPost()->getTo());

        return $repo;
    }
}

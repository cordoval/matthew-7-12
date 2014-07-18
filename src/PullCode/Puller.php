<?php

namespace Grace\PullCode;

use Grace\Domain\Container;
use Grace\Domain\Repo;

class Puller
{
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Repo $repo)
    {
        $this->clone($repo, $this->container);
        $this->checkout($repo, $this->container, 'to');

        return $repo;
    }
}

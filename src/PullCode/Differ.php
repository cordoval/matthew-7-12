<?php

namespace Grace\PullCode;

use Grace\Domain\Repo;

class Differ
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Repo $repo)
    {
        $this->container->formatPatch($repo, $repo->getHookPost()->getFrom());
    }
}

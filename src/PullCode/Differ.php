<?php

namespace Grace\PullCode;

use Grace\Domain\Container;
use Grace\Domain\Patch;
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
        $filename = $this->container->formatPatch($repo, $repo->getHookPost()->getFrom());

        return Patch::from($filename);
    }
}

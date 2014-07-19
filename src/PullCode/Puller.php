<?php

namespace Grace\PullCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class Puller
{
    use ContainerAwareTrait;

    public function __invoke(Repo $repo)
    {
        $this->container->gitClone($repo);
        $this->container->checkout($repo, $repo->getHookPost()->getTo());

        return $repo;
    }
}

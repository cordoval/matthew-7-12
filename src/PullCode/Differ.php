<?php

namespace Grace\PullCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class Differ
{
    use ContainerAwareTrait;

    public function __invoke(Repo $repo)
    {
        return $this->container->formatPatch(
            $repo,
            $repo->getHookPost()->getFrom()
        );
    }
}

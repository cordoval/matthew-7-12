<?php

namespace Grace\PullCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Patch;
use Grace\Domain\Repo;

class Differ
{
    use ContainerAwareTrait;

    public function __invoke(Repo $repo)
    {
        $filename = $this->container->formatPatch(
            $repo,
            $repo->getHookPost()->getFrom()
        );

        return Patch::from($filename);
    }
}

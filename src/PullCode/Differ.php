<?php

namespace Grace\PullCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class Differ
{
    use ContainerAwareTrait;

    public function __invoke(Repo $repo)
    {
        $fileNames = $this->container->formatPatch(
            $repo,
            $repo->getHookPost()->getFrom()
        );

        return $fileNames;
    }
}

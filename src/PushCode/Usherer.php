<?php

namespace Grace\PushCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class Usherer
{
    use ContainerAwareTrait;

    public function __invoke(Repo $repo)
    {
        $this->container->gitClone($repo);
ladybug_dump_die();
    }
}

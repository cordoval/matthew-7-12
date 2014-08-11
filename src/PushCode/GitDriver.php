<?php

namespace Grace\PushCode;
use Grace\Collabs\ContainerAwareTrait;

class GitDriver {

    use ContainerAwareTrait;

    public function createRepo($repoAndPatch)
    {
        $this->container->gitClone();
    }
} 
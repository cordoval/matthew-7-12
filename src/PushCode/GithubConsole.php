<?php

namespace Grace\PushCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class GithubConsole {

    use ContainerAwareTrait;

    public function cloneAndPach()
    {
        $this->container->gitClonePush();
    }

} 
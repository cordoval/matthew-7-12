<?php

namespace Grace\PushCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\RepoPush;

class GitConsole {

    use ContainerAwareTrait;

    public function cloneAndPatch($repoName, $patch)
    {
        $this->container->gitClonePush();
        $this->container->gitPatch();
    }

} 
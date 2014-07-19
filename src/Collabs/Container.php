<?php

namespace Grace\Collabs;

use Grace\Domain\Repo;

class Container
{
    protected $gitHelper;

    public function __construct($gitHelper)
    {
        $this->gitHelper = $gitHelper;
    }

    public function gitClone(Repo $repo)
    {
        $vendor = $repo->getHookPost()->getVendor();
        $name = $repo->getHookPost()->getName();
        $baseUrl = 'github.com';
        $command = sprintf('git clone git@%s:%s/%s.git', $baseUrl, $vendor, $name);
        $cwd = uniqid('container_folder_');
        $this->gitHelper->run($command, $cwd);
        $repo->wasClonedIn($cwd);
    }

    public function checkout(Repo $repo, $reference)
    {
        $command = sprintf('git checkout -b %s -f', $reference);
        $this->gitHelper->run($command, $cwd);

    }

    public function formatPatch(Repo $repo, $from)
    {
        return 'filename';
    }

    public function destroy()
    {

    }
}
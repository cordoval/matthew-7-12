<?php

namespace Grace\Collabs;

use Grace\Domain\Repo;

class Container
{
    protected $gitHelper;
    protected $cwd;

    public function __construct($gitHelper)
    {
        $this->gitHelper = $gitHelper;
        $this->cwd = uniqid('container_folder_');
    }

    public function gitClone(Repo $repo)
    {
        $this->gitHelper->run(
            sprintf(
                'git clone git@%s:%s/%s.git',
                $repo->getBaseUrl(),
                $repo->getHookPost()->getVendor(),
                $repo->getHookPost()->getName()
            ),
            $this->cwd
        );

        $repo->wasClonedIn($this->cwd);
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
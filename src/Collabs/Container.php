<?php

namespace Grace\Collabs;

use Grace\Domain\Repo;

class Container
{
    protected $helper;
    protected $basePath;
    protected $fs;

    public function __construct(Helper $helper, FileSystem $fs)
    {
        $this->helper = $helper;
        $this->basePath = '/tmp/grace/';
        $this->fs = $fs;
        $this->fs->mkdir($this->basePath);
    }

    public function gitClone(Repo $repo)
    {
        $this->fs->mkdir($this->basePath.$repo->getCwd());
        $this->helper->run(
            sprintf(
                'git clone git@%s:%s/%s.git .',
                $repo->getBaseUrl(),
                $repo->getHookPost()->getVendor(),
                $repo->getHookPost()->getName()
            ),
            $this->basePath.$repo->getCwd()
        );

        $repo->wasCloned();
    }

    public function checkout(Repo $repo, $reference)
    {
        $this->helper->run(
            sprintf(
                'git checkout -b %s -f',
                $reference
            ),
            $this->basePath.$repo->getCwd()
        );
    }

    public function formatPatch(Repo $repo, $from)
    {
        $this->helper->run(
            sprintf(
                'git format-patch %s -f',
                $from
            ),
            $this->basePath.$repo->getCwd()
        );

        return 'filename';
    }

    public function destroy(Repo $repo)
    {
        $this->fs->remove($this->basePath.$repo->getCwd());
    }
}

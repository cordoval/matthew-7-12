<?php

namespace Grace\Collabs;

use Grace\Domain\Repo;

class Container
{
    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function gitClone(Repo $repo)
    {
        
        $this->helper->run(
            sprintf(
                'git clone git@%s:%s/%s.git .',
                $repo->getBaseUrl(),
                $repo->getHookPost()->getVendor(),
                $repo->getHookPost()->getName()
            ),
            $repo->getCwd()
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
            $repo->getCwd()
        );
    }

    public function formatPatch(Repo $repo, $from)
    {
        return 'filename';
    }

    public function destroy()
    {

    }
}
<?php

namespace Grace\UseCases;

use Symfony\Component\HttpFoundation\Request;
use Grace\Domain\Change;
use Grace\Domain\Repo;
use Grace\Domain\Branch;
use Grace\Domain\PullRequest;

class PushCodeTest extends BaseProphecy
{
    protected $patcher;
    protected $receiver;
    protected $usherer;
    protected $container;

    public function setUp()
    {
        $this->container = static::$kernel->getContainer();
        $this->patcher = $this->container->get('grace.patcher');
        $this->receiver = $this->container->get('grace.receiver');
        $this->usherer = $this->container->get('grace.usherer');
    }

    public function it_goes_through_the_whole_push_flow(Request $request)
    {
        $this->setUp();
        $change = Change::from($request);
        $changeSet = $this->receiver($change);
        $repoChangeSet = Repo::from($changeSet);
        $clonedRepository = $this->container($repoChangeSet);
        $patch = Branch::toPatch($changeSet, $clonedRepository);
        $patchedBranch = $this->patcher($patch);
        $pullPatchedBranch = PullRequest::from($patchedBranch);
        $this->usherer($pullPatchedBranch);
    }
}

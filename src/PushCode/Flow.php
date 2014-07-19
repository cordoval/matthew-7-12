<?php

namespace Grace\PushCode;

use Grace\Domain\Branch;
use Grace\Domain\Change;
use Grace\Domain\PullRequest;
use Grace\Domain\Repo;

class Flow
{
    protected $cloner;
    protected $patcher;
    protected $receiver;
    protected $usherer;

    public function __construct(
        Patcher $patcher,
        Receiver $receiver,
        Usherer $usherer
    ) {
        $this->patcher = $patcher;
        $this->receiver = $receiver;
        $this->usherer = $usherer;
    }

    public function push($request)
    {
        $patcher = $this->patcher;
        $receiver = $this->receiver;
        $usherer = $this->usherer;

        $changeSet = $receiver(Change::from($request));
        $clonedRepo = $container(Repo::from($changeSet));
        $patchedBranch = $patcher(Branch::toPatch($changeSet, $clonedRepo));
        $usherer(PullRequest::from($patchedBranch));
    }
}

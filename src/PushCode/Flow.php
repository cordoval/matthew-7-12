<?php

namespace Grace\PushCode;

use Grace\Domain\Branch;
use Grace\Domain\Change;
use Grace\Domain\PullRequest;
use Grace\Domain\Repo;

class PushWorkflow
{
    protected $cloner;
    protected $patcher;
    protected $receiver;
    protected $usherer;

    public function __construct(
        Cloner $cloner,
        Patcher $patcher,
        Receiver $receiver,
        Usherer $usherer
    ) {
        $this->cloner = $cloner;
        $this->patcher = $patcher;
        $this->receiver = $receiver;
        $this->usherer = $usherer;
    }

    public function push($request)
    {
        $cloner = $this->cloner;
        $patcher = $this->patcher;
        $receiver = $this->receiver;
        $usherer = $this->usherer;

        $changeSet = $receiver(Change::from($request));
        $clonedRepo = $cloner(Repo::from($changeSet));
        $patchedBranch = $patcher(Branch::toPatch($changeSet, $clonedRepo));
        $usherer(PullRequest::from($patchedBranch));
    }
}
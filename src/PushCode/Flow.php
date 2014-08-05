<?php

namespace Grace\PushCode;

use Grace\Domain\Branch;
use Grace\Domain\Change;
use Grace\Domain\PullRequest;
use Grace\Domain\Repo;

class Flow
{
    protected $usherer;

    public function __construct(
        Usherer $usherer
    ) {
        $this->usherer = $usherer;
    }

    public function push($request)
    {
        $usherer = $this->usherer;
        $usherer(PullRequest::from($patchedBranch));
    }
}

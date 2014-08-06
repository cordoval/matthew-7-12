<?php

namespace Grace\PushCode;

use Grace\Domain\PullRequest;

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

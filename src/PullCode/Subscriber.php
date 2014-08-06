<?php

namespace Grace\PullCode;

class Subscriber
{
    protected $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    public function __invoke($repo)
    {
        return $this->emails;
    }
}

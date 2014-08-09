<?php

namespace Grace\PushCode;

class Reader
{
    public function __invoke(Repo $repo)
    {
        return $repo;
    }
}

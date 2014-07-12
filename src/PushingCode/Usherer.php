<?php

namespace Grace;

interface Usherer
{
    public function __invoke($patchedBranch);
}

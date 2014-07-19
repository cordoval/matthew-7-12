<?php

namespace Grace\Collabs;

use Grace\Domain\Patch;

interface Zipper
{
    public function zipAndBreak(Patch $patch);

    public function unzipAndJoin();
}

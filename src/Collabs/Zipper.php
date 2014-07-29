<?php

namespace Grace\Collabs;

interface Zipper
{
    public function zipAndBreak(array $patches);
    public function unzipAndJoin();
}

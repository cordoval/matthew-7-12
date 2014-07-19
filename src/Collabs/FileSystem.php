<?php

namespace Grace\Collabs;

interface FileSystem
{
    public function remove($path);
    public function mkdir($path);
}

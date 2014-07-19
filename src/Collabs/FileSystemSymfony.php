<?php

namespace Grace\Collabs;

use Symfony\Component\Filesystem\Filesystem as Alien;

class FileSystemSymfony implements FileSystem
{
    public function remove($path)
    {
        (new Alien())->remove($path);
    }

    public function mkdir($path)
    {
        (new Alien())->mkdir($path);
    }
}

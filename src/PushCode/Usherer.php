<?php

namespace Grace\PushCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Domain\Repo;

class Usherer
{
    use ContainerAwareTrait;

    public function __invoke($vendor, $name, $dir, $baseurl)
    {
    /*
        $this->container->gitClonePush($vendor, $name, $dir, $baseurl);
        $this->container->patch($mailInput->getRepoName(), $patch);
        $this->container->pull ();
    */
ladybug_dump_class_die();
    }
}

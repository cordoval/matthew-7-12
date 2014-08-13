<?php

namespace Grace\PushCode;

use Grace\Collabs\ContainerAwareTrait;
use Grace\Collabs\Container;
use Grace\Domain\Repo;

class Usherer
{
    protected $githubUsername;

    use ContainerAwareTrait {
        ContainerAwareTrait::__construct as private __containerConstruct;
    }

    public function __construct($container, $githubUsername)
    {
        $this->__containerConstruct($container);

        $this->githubUsername = $githubUsername;
    }

    public function __invoke($repoName, $patchPath)
    {

        $this->container->gitClonePush($this->githubUsername, $repoName);
/*
        $this->container->patch($mailInput->getRepoName(), $patch);
        $this->container->pull ();
    */
ladybug_dump_class_die("fin");
    }
}

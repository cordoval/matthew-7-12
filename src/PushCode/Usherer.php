<?php

namespace Grace\PushCode;

use Grace\Collabs\Container;
use Grace\Collabs\GitHubClient;
use Grace\Domain\Repo;

class Usherer
{
    protected $container;
    protected $client;

    public function __construct(
        Container $container,
        GitHubClient $client
    ) {
        $this->container = $container;
        $this->client = $client;
    }

    public function __invoke(Repo $repo, $patchPath)
    {
        $repoPath = $this->container->gitClonePush($repo);
        $this->container->gitApplyPatch($repoPath, $patchPath);
        $this->client->fork($repo);
        $this->client->pullRequest($repo);
    }
}

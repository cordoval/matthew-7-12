<?php

namespace Grace\PullCode;

use Grace\Collabs\Container;
use Grace\Domain\RepoRepository;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class RemoveContainerListener
{
    protected $repoRepository;
    protected $container;

    public function __construct(
        RepoRepository $repoRepository,
        Container $container
    ) {
        $this->repoRepository = $repoRepository;
        $this->container = $container;
    }

    public function onTerminate(PostResponseEvent $event)
    {
        $id = $event->getResponse();
        $repo = $this->repoRepository->findBy(['id' => $id]);
        $this->container->destroy($repo);
    }
}

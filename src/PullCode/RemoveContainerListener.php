<?php

namespace Grace\PullCode;

use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class RemoveContainerListener
{
    protected $repoRepository;
    protected $container;

    public function __construct(
        RepoRepository $repoRepository
        Container $container
    ) {
        $this->repoRepository = $repoRepository;
        $this->container = $container;
    }

    public function onTerminate(PostResponseEvent $event)
    {
        $id = $event->getResponse();
        $repo = $this->repoRepository->findById($id);
        $this->container->destroy($repo);
    }
}

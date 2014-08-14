<?php

namespace Grace\PullCode;

use Grace\Collabs\Collab;
use Grace\Collabs\Container;
use Grace\Domain\GithubPost;
use Grace\Domain\Repo;
use Symfony\Component\HttpFoundation\Request;

class Flow
{
    protected $puller;
    protected $differ;
    protected $zipper;
    protected $subscriber;
    protected $mailer;
    protected $container;
    protected $from;
    protected $baseMailer;

    public function __construct(
        Puller $puller,
        Differ $differ,
        Collab $zipper,
        Subscriber $subscriber,
        Collab $mailer,
        Container $container,
        $from,
        $baseMailer
    ) {
        $this->puller = $puller;
        $this->differ = $differ;
        $this->zipper = $zipper;
        $this->subscriber = $subscriber;
        $this->mailer = $mailer;
        $this->container = $container;
        $this->from = $from;
        $this->baseMailer = $baseMailer;
    }

    public function pull(Request $request)
    {
        $hookPost = GithubPost::fromRequest($request);
        $repo = $this->puller->__invoke(Repo::fromHook($hookPost));
        $patches = $this->differ->__invoke($repo);
        $manyCompressed = $this->zipper->__invoke($patches);
        $list = $this->subscriber->__invoke($repo);
        $this->mailer->__invoke($list, $manyCompressed, $this->from, $this->baseMailer);
        $this->container->destroy($repo);
    }
}

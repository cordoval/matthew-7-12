<?php

namespace Grace\UseCases;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Grace\Domain\Repo;

/**
 * @group push
 */
class PushCodeTest extends WebTestCase
{
    protected $poller;
    protected $reader;
    protected $unzipper;
    protected $usherer;
    protected $container;

    public function setUp()
    {
        $this->container = static::$kernel->getContainer();
        $this->poller = $this->container->get('grace.poller');
        $this->reader = $this->container->get('grace.reader');
        $this->unzipper = $this->container->get('grace.unzipper');
        $this->usherer = $this->container->get('grace.usherer');
    }

    /**
     * @test
     */
    public function it_goes_through_the_whole_push_flow(Request $request)
    {
        $gotEmail = Poller::pollFromNotification($request);
        $zipped = $this->downloader->__invoke($gotEmail);
        $patch = $this->unzipper->__invoke($zipped);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }
}

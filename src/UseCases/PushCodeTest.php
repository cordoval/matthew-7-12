<?php

namespace Grace\UseCases;

use Grace\Domain\Repo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

use Grace\Domain\Poller;

class PushCodeTest extends WebTestCase
{
    protected $container;
    protected $puller;
    protected $differ;
    protected $subscriber;
    protected $mailer;
    protected $zipper;
    protected $from;
    protected $baseMailer;
    protected $client;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();
        $this->client->enableProfiler();

        $container = static::$kernel->getContainer();
        $this->puller = $container->get('grace.puller');
        $this->differ = $container->get('grace.differ');
        $this->subscriber = $container->get('grace.subscriber');
        $this->mailer = $container->get('grace.mailer');
        $this->zipper = $container->get('grace.zipper');
        $this->from = $container->getParameter('from');
        $this->baseMailer = $container->get('swiftmailer.mailer');
        $this->container = $container->get('grace.container');
    }

    /**
     * @test
     * @dataProvider getRequestExamples
     */
    public function it_goes_through_the_whole_push_flow(Request $request)
    {
        $gotEmail = Poller::pollFromNotification($request);
        $zipped = $this->downloader->__invoke($gotEmail);
        $patch = $this->unzipper->__invoke($zipped);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }

    public function getRequestExamples()
    {
        return [
            [$this->getRequest(file_get_contents(__DIR__.'/Fixtures/request.json'))],
//            [$this->getRequest(file_get_contents(__DIR__.'/Fixtures/request.json'))],
        ];
    }

    private function getRequest($content)
    {
        return new Request([], [], [], [], [], [], json_decode($content, true));
    }

    protected static function getKernelClass()
    {
        return 'Grace\\AppKernel';
    }
}

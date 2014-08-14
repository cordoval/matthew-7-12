<?php

namespace Grace\UseCases;

use Grace\Domain\GithubPost;
use Grace\Domain\Repo;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group pull
 */
class PullCodeTest extends BaseTestCase
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

        $container = static::$kernel->getContainer();
        $this->puller = $container->get('grace.puller');
        $this->differ = $container->get('grace.differ');
        $this->subscriber = $container->get('grace.subscriber');
        $this->mailer = $container->get('grace.mailer');
        $this->zipper = $container->get('grace.zipper');
        $this->from = $container->getParameter('grace.from');
        $this->baseMailer = $container->get('swiftmailer.mailer');
        $this->container = $container->get('grace.container');
    }

    /**
     * @test
     * @dataProvider getRequestExamples
     */
    public function it_goes_through_the_whole_pull_flow(Request $request)
    {
        $hookPost = GithubPost::fromRequest($request);
        $repo = $this->puller->__invoke(Repo::fromHook($hookPost));
        $patches = $this->differ->__invoke($repo);
        $manyCompressed = $this->zipper->__invoke($patches);
        $list = $this->subscriber->__invoke($repo);
        $this->mailer->__invoke($list, $manyCompressed, $this->from, $this->baseMailer);
    }

    public function getRequestExamples()
    {
        return [
            [$this->getRequest(file_get_contents(__DIR__.'/Fixtures/request.json'))],
        ];
    }

    private function getRequest($content)
    {
        return new Request([], [], [], [], [], [], $content);
    }
}

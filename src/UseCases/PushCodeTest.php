<?php

namespace Grace\UseCases;

use Grace\Domain\Repo;
use Grace\Domain\GithubPost;

/**
 * @group push
 */
class PushCodeTest extends BaseTestCase
{
    protected $poller;
    protected $reader;
    protected $unzipper;
    protected $usherer;
    protected $container;
    protected $client;
    protected $pushGitDriver;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();

        $container = static::$kernel->getContainer();
        $this->reader = $container->get('grace.reader');
        $this->container = $container->get('grace.container');
        $this->unzipper = $container->get('grace.unzipper');
        $this->usherer = $container->get('grace.usherer');
    }

    /**
     * @test
     * @group now
     */
    public function it_goes_through_the_whole_push_flow()
    {
        $projectName = 'INBOX';
        $repoAndZipAttachment = $this->reader->__invoke($projectName);
        $repoAndPatch = $this->unzipper->__invoke($repoAndZipAttachment);
        $hookPost = GithubPost::fromEmail($repoAndPatch);
        $repo = Repo::fromHook($hookPost);
        $this->usherer->__invoke($repo);
    }
}

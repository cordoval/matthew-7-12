<?php

namespace Grace\UseCases;

use Grace\Domain\Repo;

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

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();

        $container = static::$kernel->getContainer();
        $this->reader = $container->get('grace.reader');
        $this->container = $container->get('grace.container');
        $this->unzipper = $container->get('grace.unzipper');
        $this->usherer = $container->get('grace.usherer');
        $this->gitDriver = $container->get('grace.git.driver');
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
        $repoDriver = $this->gitDriver->createRepo($repoAndPatch);

        $repo = Repo::fromPatch($repoAndPatch);
        $this->usherer->__invoke($repo, $repo->to);
    }
}

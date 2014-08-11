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
    }

    /**
     * @test
     * @group now
     */
    public function it_goes_through_the_whole_push_flow()
    {
        $projectName = 'INBOX';
        $repoAndAttachment = $this->reader->__invoke($projectName);

ladybug_dump_die($repoAndAttachment);
         // operations with container are done in services not here
        $unzipResponse = GithubPush::unzippPach($messageResponse);
        $patch = $this->unzipper->__invoke($zippedAttachment);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }
}

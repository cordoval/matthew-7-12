<?php

namespace Grace\UseCases;

use Grace\Domain\GithubInput;
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
    protected $pushGitDriver;
    protected $buildsPath;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();

        $container = static::$kernel->getContainer();
        $this->reader = $container->get('grace.reader');
        $this->container = $container->get('grace.container');
        $this->unzipper = $container->get('grace.unzipper');
        $this->usherer = $container->get('grace.usherer');
        $this->buildsPath = $container->getParameter('builds_base_path');
    }

    /**
     * @test
     * @group now
     */
    public function it_goes_through_the_whole_push_flow()
    {
        $projectName = 'INBOX';
        $repoAndZipAttachment = $this->reader->__invoke($projectName);
        $patch = $this->unzipper->__invoke($repoAndZipAttachment['attachment'], $this->buildsPath);
        $hookInput = GithubInput::fromEmailSubject($repoAndZipAttachment['repo']);
        $repo = Repo::fromHook($hookInput);
        $this->usherer->__invoke($repo);
ladybug_dump_die($repo);
        $this->container->destroy($repo);
    }
}

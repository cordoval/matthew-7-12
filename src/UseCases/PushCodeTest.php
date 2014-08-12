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
    protected $githubUser;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();

        $container = static::$kernel->getContainer();
        $this->reader = $container->get('grace.reader');
        $this->container = $container->get('grace.container');
        $this->unzipper = $container->get('grace.unzipper');
        $this->usherer = $container->get('grace.usherer');
<<<<<<< HEAD
        $this->githubapi = $container->get('grace.githubapi');
=======
        $this->githubapi = $container->get('grace.github_client');
>>>>>>> b11ef452068ce253537341a04a3bac961fa6187f
        $this->buildsPath = $container->getParameter('builds_base_path');
        $this->githubUser = $container->getParameter('github_username');
    }

    /**
     * @test
     * @group now
     */
    public function it_goes_through_the_whole_push_flow()
    {
<<<<<<< HEAD

        $projectName = 'INBOX';
        $repoAndZipAttachment = $this->reader->__invoke($projectName);
        $patch = $this->unzipper->__invoke($repoAndZipAttachment['attachment'], $this->buildsPath);
        $hookInput = GithubInput::fromEmailSubject($this->githubUser, $repoAndZipAttachment['repo']);
        $this->githubapi->fork($this->githubUser, $hookInput->getName());
        $repo = Repo::fromHook($hookInput);
        $this->usherer->__invoke($repo,$patch);
=======
ladybug_dump_die($this->githubapi->fork('matthew-7-12', 'testRepo'));
        $projectName = 'INBOX';
        $repoAndZipAttachment = $this->reader->__invoke($projectName);
        $patch = $this->unzipper->__invoke($repoAndZipAttachment['attachment'], $this->buildsPath);
        $hookInput = GithubInput::fromEmailSubject($repoAndZipAttachment['repo']);
        $repo = Repo::fromHook($hookInput);
        $this->usherer->__invoke($repo);

>>>>>>> b11ef452068ce253537341a04a3bac961fa6187f
        $this->container->destroy($repo);
    }
}

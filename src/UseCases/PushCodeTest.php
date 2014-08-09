<?php

namespace Grace\UseCases;

use Symfony\Component\HttpFoundation\Request;
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

    public function setUp()
    {
        self::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->reader = $this->container->get('grace.reader');
        $this->unzipper = $this->container->get('grace.unzipper');
        $this->usherer = $this->container->get('grace.usherer');
    }

    /**
     * @test
     */
    public function it_goes_through_the_whole_push_flow()
    {
        $this->reader->enableConnection();
        $inbox = $this->reader->selectMailbox('INBOX');
        $message = $this->reader->setMailbox($inbox)->setSearchNoFlagPushed();
        $message = $inbox->getMessages(new SearchExpression(' UNFLAGGED "PUSHED"'));

        $this->container->gitClone($message->getSubject());
        $reposUrl = $reader->readSubject();
        $gitHub = new GithubPush();
        $messagesResponse = $gitHub->createRepo($message->getSubject());
        $unzippResponse = GithubPush::unzippPach($messageResponse);
        $pullRequestResponse = GithubPush::pullRequest($unzippResponse);

        $responseMessage = SMTPServer($pullRequestResponse);

        GitHub::detroyRepos($pullRequestResponse);

        $connection = $server->pollFromNotification();
        $mailUID = $emailClient->searchFirstUnpushed('INBOX');
        $zipped = $this->reader->__invoke($gotEmail);
        $patch = $this->unzipper->__invoke($zipped);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }
}

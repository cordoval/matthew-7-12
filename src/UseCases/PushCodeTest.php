<?php

namespace Grace\UseCases;

use Grace\Domain\Repo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Grace\ImapReader\ImapServer;
use Ddeboer\Imap\SearchExpression;
use Grace\Domain\GithubPush;
use Grace\Domain\Poller;

class PushCodeTest extends WebTestCase
{
    protected $container;
    protected $client;

    protected $server;
    protected $username;
    protected $password;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();
        $this->client->enableProfiler();

        $container = static::$kernel->getContainer();

        $this->username = $container->getParameter('incoming_emails_account');
        $this->password = $container->getParameter('incoming_emails_password');
        $this->server = $container->getParameter('incoming_emails_server');
    }

    /**
     * @test
     * @dataProvider getRequestExamples
     */
    public function it_goes_through_the_whole_push_flow()
    {
        /**
         * patch via email is sent zipped
         * check email with php imap specified email account for an attachment
         * subject resolver : resolves email subject format (for now we assume they are always just one email)
         * download attachment -> unzip = file.patch
         * create repo & apply patch file.patch
         * given appropriate name push to fork
         * matthew account in github must be used - ssh key to be able to push to its own fork
         * open PR with library api
         */
        $server = ImapServer::initServer($this->server);
        $connection = $server->getConnection($this->username, $this->password);
        $inbox = $connection->getMailbox('INBOX');
        $messages = $inbox->getMessages(new SearchExpression(' UNFLAGGED "PUSHED"'));
        $messagesResponses = GithubPush::createRepos($messages);
        $unzippResponses = GithubPush::unzippPaches($messagesResponses);
        $pullRequestResponses = GithubPush::pullRequest($unzippResponses);
        $responseMessages = SMTPServer($pullRequestResponses);
        GitHub::detroyRepos($pullRequestResponses);
ladybug_dump_die($messages);
        $connection = $server->pollFromNotification();
        $mailUID = $emailClient->searchFirstUnpushed('INBOX');
        $zipped = $this->downloader->__invoke($gotEmail);
        $patch = $this->unzipper->__invoke($zipped);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }

    public function getRequestExamples()
    {
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

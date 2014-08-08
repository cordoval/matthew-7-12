<?php

namespace Grace\UseCases;

use Grace\Domain\Repo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

use Grace\Domain\Poller;

class PushCodeTest extends WebTestCase
{
    protected $container;
    protected $client;

    protected $imapConnection;

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->client->insulate();
        $this->client->enableProfiler();

        $container = static::$kernel->getContainer();
        $this->imapConnection = array(
            'username' => $container->getParameter('incoming_emails_account'),
            'password' => $container->getParameter('incoming_emails_password'),
            'hostspec' => $container->getParameter('incoming_emails_server'),
            'port' => $container->getParameter('incoming_emails_port'),
            'secure' => $container->getParameter('incoming_emails_secure'),
            )
        ;
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
        $emailClient = Poller::pollFromNotification($this->imapConnection);
        $results = $emailClient->search('INBOX');
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

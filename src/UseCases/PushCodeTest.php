<?php

namespace Grace\UseCases;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Grace\Domain\Repo;

/**
 * @group push
 */
class PushCodeTest extends WebTestCase
{
    protected $poller;
    protected $downloader;
    protected $unzipper;
    protected $usherer;
    protected $container;

    public function setUp()
    {
        $this->container = static::$kernel->getContainer();
        $this->poller = $this->container->get('grace.poller');
        $this->downloader = $this->container->get('grace.downloader');
        $this->unzipper = $this->container->get('grace.unzipper');
        $this->usherer = $this->container->get('grace.usherer');
    }

    /**
     * @test
     */
    public function it_goes_through_the_whole_push_flow(Request $request)
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
        $gotEmail = Poller::pollFromNotification($request);
        $zipped = $this->downloader->__invoke($gotEmail);
        $patch = $this->unzipper->__invoke($zipped);
        $repo = Repo::fromPatch($patch);
        $this->usherer->__invoke($repo, $repo->to);
    }
}

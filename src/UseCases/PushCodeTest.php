<?php

namespace Grace\UseCases;

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
     */
    public function it_goes_through_the_whole_push_flow()
    {
        $mailInput = $this->reader->__invoke($projectName = 'INBOX');
        $patchPath = $this->unzipper->__invoke($mailInput->getAttachment(), $this->buildsPath);
        $this->usherer->__invoke($mailInput, $patchPath);
    }
}

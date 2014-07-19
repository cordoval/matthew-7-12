<?php

namespace Grace\UseCases;

use Grace\Collabs\MailerSwift;
use Grace\Collabs\ZipperZippy;
use Grace\Domain\Container;
use Grace\Domain\GithubPost;
use Grace\Domain\MailList;
use Grace\Domain\Repo;
use Grace\PullCode\Differ;
use Grace\PullCode\Puller;
use Grace\PullCode\Subscriber;
use Symfony\Component\HttpFoundation\Request;

class PullCodeTest extends BaseProphecy
{
    public function setUp()
    {
        $container = new Container();
        $puller = new Puller($container);
        $differ = new Differ($container);
        $subscriber = new Subscriber();
        $mailer = function ($list, $manyCompressed) {
            foreach ($manyCompressed as $zipFile) {
                (new MailerSwift())
                    ->create($list)
                    ->attach($zipFile)
                    ->send()
                ;
            }

            return true;
        };
        $zipper = function ($patch) {
            return (new ZipperZippy())->zipAndBreak($patch);
        };
    }
    /**
     * @test
     */
    public function it_goes_through_the_whole_pull_flow()
    {
        $request = new Request();
        $hookPost = GithubPost::fromRequest($request);
        $repo = $puller(Repo::fromHook($hookPost));
        $this->assertInstanceOf('Grace\Domain\Repo', $repo);
        $patch = $differ($repo);
        $this->assertInstanceOf('Grace\Domain\Patch', $patch);
        $manyCompressed = $zipper($patch);
        $list = $subscriber($repo);
        $mailer($list, $manyCompressed);
        $container->destroy();
    }
}
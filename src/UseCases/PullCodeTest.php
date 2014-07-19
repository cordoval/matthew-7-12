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
    /**
     * @test
     */
    public function it_goes_through_the_whole_pull_flow()
    {
        $container = new Container();
        $puller = new Puller($container);
        $differ = new Differ($container);
        $subscriber = new Subscriber();
        $mailer = function () {
            (new MailerSwift())->send();

            return true;
        };
        $zipper = function ($patchSet) {
            (new ZipperZippy())->unzipAndJoin($patchSet);

            return true;
        };

        $request = new Request();
        $hookPost = GithubPost::fromRequest($request);
        $repo = $puller(Repo::fromHook($hookPost));
        $this->assertInstanceOf('Grace\Domain\Repo', $repo);
        $patch = $differ($repo);
        $this->assertInstanceOf('Grace\Domain\Patch', $patch);
        $compressedSet = $zipper($patch);
        $list = $subscriber($repo);
        $mailer($list, $compressedSet);
    }
}
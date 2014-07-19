<?php

namespace Grace\UseCases;

use Grace\Collabs\MailerSwift;
use Grace\Collabs\ZipperZippy;
use Grace\Domain\Container;
use Grace\Domain\GithubPost;
use Grace\Domain\Repo;
use Grace\PullCode\Differ;
use Grace\PullCode\Puller;
use Grace\PullCode\Subscriber;
use Symfony\Component\HttpFoundation\Request;

class PullCodeTest extends BaseProphecy
{
    protected $container;
    protected $puller;
    protected $differ;
    protected $subscriber;
    protected $mailer;
    protected $zipper;

    public function setUp()
    {
        parent::setUp();
        $this->mailer = function (array $list, $manyCompressed) {
            foreach ($manyCompressed as $zipFile) {
                (new MailerSwift())
                    ->create($list)
                    ->attach($zipFile)
                    ->send()
                ;
            }

            return true;
        };
        $this->zipper = function ($patch) {
            return (new ZipperZippy())->zipAndBreak($patch);
        };
    }

    /**
     * @test
     * @getRequestExamples
     */
    public function it_goes_through_the_whole_pull_flow(Request $request)
    {
        $pull = $this->puller;
        $diff = $this->differ;
        $zip = $this->zipper;
        $subscribe = $this->subscriber;
        $mail = $this->mailer;

        $hookPost = GithubPost::fromRequest($request);
        $repo = $pull(Repo::fromHook($hookPost));
        $patch = $diff($repo);
        $manyCompressed = $zip($patch);
        $list = $subscribe($repo);
        $mail($list, $manyCompressed);
        $this->container->destroy();
    }

    public function getRequestExamples()
    {
        return [
            [new Request()]
        ];
    }
}
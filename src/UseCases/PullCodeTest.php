<?php

namespace Grace\UseCases;

use Grace\Domain\GithubPost;
use Grace\Domain\Repo;
use Symfony\Component\HttpFoundation\Request;

class PullCodeTest extends BaseProphecy
{
    protected $container;
    protected $puller;
    protected $differ;
    protected $subscriber;
    protected $mailer;
    protected $zipper;

    /**
     * @test
     * @dataProvider getRequestExamples
     */
    public function it_goes_through_the_whole_pull_flow(Request $request)
    {
        $pull = $this->prophesy('Grace\PullCode\Puller');
        $diff = $this->prophesy('Grace\Collabs\ZipperZippy');
        $zip = $this->prophesy('Grace\PullCode\Differ');
        $subscribe = $this->prophesy('Grace\PullCode\Subscriber');
        $mail = $this->prophesy('Grace\Collabs\MailerSwift');

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
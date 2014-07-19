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
        $repo = $pull->__invoke(Repo::fromHook($hookPost));
        $patch = $diff->__invoke($repo);
        $manyCompressed = $zip->__invoke($patch);
        $list = $subscribe->__invoke($repo);
        $mail->__invoke($list, $manyCompressed);
        $this->container->destroy();
    }

    public function getRequestExamples()
    {
        return [
            [$this->getRequest(file_get_contents(__DIR__.'/Fixtures/request.json'))]
        ];
    }

    private function getRequest($content)
    {
        return new Request([], [], [], [], [], [], json_decode($content, true));
    }
}
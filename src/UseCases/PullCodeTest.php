<?php

namespace Grace\UseCases;

use Grace\Collabs\MailerSwift;
use Grace\Collabs\ZipperZippy;
use Grace\Domain\Branch;
use Grace\Domain\GithubPost;
use Grace\Domain\MailList;
use Grace\Domain\Notification;
use Grace\Domain\Repo;
use Grace\PullCode\Differ;
use Grace\PullCode\Notifier;
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
        $puller = new Puller();
        $differ = new Differ();
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

        $notifier = new Notifier();
        $notification = $notifier(Notification::fromWebhook($hookPost));

        $this->assertInstanceOf('Grace\Domain\Notification', $notification);

        $repo = $puller(Repo::fromNotification($notification));

        $this->assertInstanceOf('Grace\Domain\Repo', $repo);

        $patchSet = $differ(Branch::fromNotification($notification));

        $this->assertInstanceOf('Grace\Domain\PatchSet', $patchSet);

        $payloadSet = $zipper($patchSet);
        $list = $subscriber(MailList::from($repo));
        $mailer(MailList::withPayload($list, $payloadSet));
    }
}
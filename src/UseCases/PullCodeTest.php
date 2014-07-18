<?php

namespace Grace\UseCases;

use Grace\Collabs\MailerSwift;
use Grace\Collabs\ZipperZippy;
use Grace\Domain\Branch;
use Grace\Domain\MailList;
use Grace\Domain\Notification;
use Grace\Domain\Repo;
use Grace\PullCode\Differ;
use Grace\PullCode\Notifier;
use Grace\PullCode\Puller;
use Grace\PullCode\Subscriber;

class PullCodeTest extends BaseProphecy
{
    /**
     * @test
     */
    public function it_receives_request_turning_it_into_a_notification()
    {
        $request = $this->prophesy('Symfony\Component\HttpFoundation\Request');
        $notifier = new Notifier();
        $notification = $notifier(Notification::fromWebhook($request->reveal()));

        $this->assertInstanceOf('Grace\Domain\Notification', $notification);

        $puller = new Puller();
        $repo = $puller(Repo::fromNotification($notification));

        $this->assertInstanceOf('Grace\Domain\Repo', $repo);

        $differ = new Differ();
        $patchSet = $differ(Branch::fromNotification($notification));

        $this->assertInstanceOf('Grace\Domain\PatchSet', $patchSet);

        $zipper = function ($patchSet) {
            (new ZipperZippy())->unzipAndJoin($patchSet);

            return true;
        };

        $payloadSet = $zipper($patchSet);

        $subscriber = new Subscriber();
        $list = $subscriber(MailList::from($repo));

        $mailer = function () {
            (new MailerSwift())->send();

            return true;
        };

        $mailer(MailList::withPayload($list, $payloadSet));
    }
}
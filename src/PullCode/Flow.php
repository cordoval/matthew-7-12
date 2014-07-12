<?php

namespace Grace\PullCode;

use Grace\Collabs\Mailer;
use Grace\Collabs\Zipper;
use Grace\Domain\Branch;
use Grace\Domain\MailList;
use Grace\Domain\Notification;
use Grace\Domain\Repo;

class PullWorkflow
{
    protected $notifier;
    protected $puller;
    protected $differ;
    protected $zipper;
    protected $subscriber;
    protected $mailer;

    public function __construct(
        Notifier $notifier,
        Puller $puller,
        Differ $differ,
        Zipper $zipper,
        Subscriber $subscriber,
        Mailer $mailer
    ) {
        $this->notifier = $notifier;
        $this->puller = $puller;
        $this->differ = $differ;
        $this->zipper = $zipper;
        $this->subscriber = $subscriber;
        $this->mailer = $mailer;
    }

    public function pull($request)
    {
        $notices = $this->notifier;
        $pulls = $this->puller;
        $diffs = $this->differ;
        $zips = $this->zipper;
        $subscribes = $this->subscriber;
        $mails = $this->mailer;

        $notification = $notices(Notification::fromWebhook($request));
        $repo = $pulls(Repo::from($notification));
        $patchSet = $diffs(Branch::from($notification));
        $payloadSet = $zips($patchSet);
        $list = $subscribes(MailList::from($repo));
        $mails(MailList::withPayload($list, $payloadSet));
    }
}

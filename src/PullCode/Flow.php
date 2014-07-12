<?php

namespace Grace\PullCode;

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

    }

    public function pull($request)
    {
        $notification = $notifier(Notification::fromWebhook($request));
        $repo = $puller(Repo::from($notification));
        $patchSet = $differ(Branch::from($notification));
        $payloadSet = $zipper($patchSet);
        $list = $subscriber(MailList::from($repo));
        $mailer(Mails::from(MailList::withPayload($list, $payloadSet));
    }
}

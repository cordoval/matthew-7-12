<?php

namespace Grace\PullCode;

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
        $list = $subscriber(List::from($repo));
        $mailer(Mails::from(List::withPayload($list, $payloadSet));
    }
}

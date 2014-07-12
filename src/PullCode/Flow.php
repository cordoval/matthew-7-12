<?php

namespace Grace\PullCode;

class PullWorkflow
{
    public function __construct(

    ) {

    }

    public function pull($request)
    {
        $notification = $notifier(Notification::fromWebhook($request));
        // merge/commit puller pulls git objects
        // patch creator creates patch
        // zipper zips patch
        // subscriber fills in list
        // mailer mails patch to list
    }
}

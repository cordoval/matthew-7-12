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

class PushCodeTest extends BaseProphecy
{
    /**
     * @test
     */
    public function it_goes_through_the_whole_pull_flow()
    {

    }
}
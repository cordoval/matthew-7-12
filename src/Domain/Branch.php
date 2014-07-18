<?php

namespace Grace\Domain;

class Branch
{
    public static function toPatch($changeSet, $repo)
    {

    }

    public static function fromNotification(Notification $notification)
    {
        $branch = new self;
        $branch->metadata = fn($notification);

        return $branch;
    }

    private function __construct()
    {
    }
}

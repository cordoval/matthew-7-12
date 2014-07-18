<?php

namespace Grace\Domain;

class Repo
{
    public static function from($changeSet)
    {

    }

    public static function fromNotification($notification)
    {
        $repo = new self;
        $repo->metadata = fn($notification);

        return $repo;
    }

    private function __construct()
    {
    }
}

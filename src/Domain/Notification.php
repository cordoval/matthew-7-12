<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Notification
{
    protected $metadata;

    public static function from($request)
    {

    }

    public static function fromWebhook(Request $request)
    {
        $notification = new self;
        $notification->metadata = fn($request);

        return $notification;
    }

    private function __construct()
    {
    }
}

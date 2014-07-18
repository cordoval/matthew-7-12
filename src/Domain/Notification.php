<?php

namespace Grace\Domain;

class Notification extends BaseDomain
{
    protected $post;

    public static function fromHook(HookPost $hookPost)
    {
        $notification = new self;
        $notification->post = $hookPost;

        return $notification;
    }
}

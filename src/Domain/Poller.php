<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Poller
{
    protected $email;
    protected $from;
    protected $to;
    protected $name;

    public static function pollFromNotification(Request $request)
    {
        $content = (array) $request->getContent();

        $hook = new self;

        return $hook;
    }
}
<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Poller extends \Horde_Imap_Client_Socket
{
    protected $email;
    protected $from;
    protected $to;
    protected $name;

    public static function pollFromNotification()
    {

        return $hook;
    }
}
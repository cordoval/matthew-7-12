<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Poller extends \Horde_Imap_Client_Socket
{
    public static function pollFromNotification($imapConnection)
    {
        return new self($imapConnection);
    }
}
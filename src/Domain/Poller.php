<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;
use Ddeboer\Imap\Server as ImapServer;

class Poller extends ImapServer
{
    public function searchFirstUnpushed($box)
    {
    ladybug_dump_die($result);
        return $result;
    }

}


    public static function pollFromNotification($server)
    {
        return new self($server);
    }
}
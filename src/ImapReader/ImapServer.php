<?php

namespace Grace\ImapReader;

use Ddeboer\Imap\Server;

class ImapServer extends Server
{
    public function getConnection($username, $password)
    {
        return $this->authenticate($username, $password);
    }

    public static function initServer($server)
    {
        return new self($server);
    }
}
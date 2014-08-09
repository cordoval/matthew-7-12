<?php

namespace Grace\Collabs;

use Ddeboer\Imap\Server;

class ImapReader implements Imap
{
    protected $imapServer;
    protected $username;
    protected $password;

    public function __construct($imapServer, $username, $password)
    {
        $this->imapServer = $imapServer;
        $this->username = $username;
        $this->password = $password;
    }
} 
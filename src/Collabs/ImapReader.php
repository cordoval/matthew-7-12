<?php

namespace Grace\Collabs;

use Ddeboer\Imap\Server;

class ImapReader extends Server implements Imap
{
    protected $username;
    protected $password;

    public function __construct($hostname, $username, $password, $port = 993, $flags = '/imap/ssl/validate-cert')
    {
        $this->username = $username;
        $this->password = $password;
        parent::__construct($hostname, $port, $flags);
    }
}

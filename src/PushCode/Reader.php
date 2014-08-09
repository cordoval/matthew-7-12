<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Server;

class Reader extends Server
{
    protected $username;
    protected $password;
    protected $mailbox;

    public function __construct($hostname, $username, $password, $port = 993, $flags = '/imap/ssl/validate-cert')
    {
        $this->username = $username;
        $this->password = $password;
        $this->mailbox = null;
        parent::__construct($hostname, $port, $flags);
    }

    public function getConnection()
    {
        return $this->authenticate($this->username, $this->password);
    }

    public function selectMailbox($nameMailbox)
    {
        $this->mailbox = $this->connection->getMailbox($nameMailbox);
    }

    public function __invoke(Repo $repo)
    {
        return $repo;
    }
}

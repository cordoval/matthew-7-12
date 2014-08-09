<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;

class Reader extends Server
{
    protected $username;
    protected $password;
    protected $mailbox;
    protected $serverConnection;

    public function __construct($hostname, $username, $password, $port = 993, $flags = '/imap/ssl/validate-cert')
    {
        $this->username = $username;
        $this->password = $password;
        $this->mailbox = null;
        $this->serverConnection = null;
        parent::__construct($hostname, $port, $flags);
    }

    public function enableConnection()
    {
        return $this->serverConnection = $this->authenticate($this->username, $this->password);
    }

    public function selectMailbox($nameMailbox)
    {
        $this->mailbox = $this->serverConnection->getMailbox($nameMailbox);
    }

    public function SearchNoFlagPushed()
    {
        $messages = $this->mailbox->getMessages(new SearchExpression(' UNFLAGGED "PUSHED"'));
        return $messages->current();
    }

    public function __invoke(Repo $repo)
    {
        return $repo;
    }
}

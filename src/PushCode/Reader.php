<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Server;

class Reader extends Server
{
    protected $username;
    protected $password;

    public function __construct($hostname, $username, $password, $port = 993, $flags = '/imap/ssl/validate-cert')
    {
        $this->username = $username;
        $this->password = $password;
        parent::__construct($hostname, $port, $flags);
    }

    public function getConnection()
    {
        return $this->authenticate($this->username, $this->password);
    }

    public function __invoke(Repo $repo)
    {
        return $repo;
    }
}

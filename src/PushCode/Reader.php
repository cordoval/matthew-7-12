<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Server as ImapServer;
use Ddeboer\Imap\SearchExpression;

class Reader
{
    const IMAP_UNFLAGGED = 'UNFLAGGED';
    const IMAP_FLAG_PUSH_LABEL = 'PUSHED';

    /** @var \Ddeboer\Imap\Connection */
    protected $connection;

    public function __construct($hostname, $username, $password)
    {
        $server = new ImapServer($hostname, $port = 993, $flags = '/imap/ssl/validate-cert');
        $this->connection = $server->authenticate($username, $password);
    }

    public function createFolder($projectFolder)
    {
        return $this->connection->createMailbox($projectFolder);
    }

    public function getMessageToPush($projectFolder)
    {
        $mailbox = $this->connection->getMailbox($projectFolder);

        return $mailbox
            ->getMessages(new SearchExpression(
                    sprintf(
                        ' %s "%s"',
                        self::IMAP_UNFLAGGED,
                        self::IMAP_FLAG_PUSH_LABEL
                    )
                )
            )
            ->current()
        ;
    }

    public function __invoke(Repo $repo)
    {
        return $repo;
    }
}

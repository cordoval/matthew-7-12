<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Exception\MailboxDoesNotExistException;
use Ddeboer\Imap\Server as ImapServer;
use Ddeboer\Imap\SearchExpression;
use Grace\Domain\Repo;

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

    /**
     * @param string $projectFolder
     *
     * @return \Ddeboer\Imap\Message|bool Even if it is empty we can find out with attachment
     */
    public function __invoke($projectFolder)
    {
        try {
            $mailbox = $this->connection->getMailbox($projectFolder);
        } catch (MailboxDoesNotExistException $exception) {
            $mailbox = $this->connection->createMailbox($projectFolder);
        }

        $result = $mailbox
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

        if ($result->hasAttachments()) {
            return $result->getAttachments();
        }

        return false;
    }
}

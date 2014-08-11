<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Exception\MailboxDoesNotExistException;
use Ddeboer\Imap\Server as ImapServer;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Message;
use Grace\Domain\Repo;

class Reader
{
    const IMAP_UNFLAGGED = 'UNFLAGGED';
    const IMAP_FLAG_PUSH_LABEL = 'PUSHED';
    const NO_EMAIL_FOUND = false;

    /** @var \Ddeboer\Imap\Connection */
    protected $connection;
    protected $rejectFolder;

    public function __construct($hostname, $username, $password, $rejectFolder)
    {
        $server = new ImapServer($hostname, $port = 993, $flags = '/imap/ssl/validate-cert');
        $this->connection = $server->authenticate($username, $password);

        try {
            $this->rejectFolder = $this->connection->getMailbox($rejectFolder);
        } catch (MailboxDoesNotExistException $exception) {
            $this->rejectFolder = $this->connection->createMailbox($rejectFolder);
        }
    }

    public function getAttachment(Message $message)
    {
        return $message->getAttachments()[0];
    }

    /**
     * @param string $projectFolder
     *
     * @return \Ddeboer\Imap\Message\Attachment[]|bool Even if it is empty we can find out with attachment
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
            $attachment = $result->getAttachments()[0];

            if(preg_match('/^.*\.zip$/i',$attachment->getFilename())){
                return $attachment;
            }
        }

        $result->move($this->rejectFolder);

        return self::NO_EMAIL_FOUND;
    }
}

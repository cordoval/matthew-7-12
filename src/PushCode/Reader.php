<?php

namespace Grace\PushCode;

use Ddeboer\Imap\Exception\MailboxDoesNotExistException;
use Ddeboer\Imap\Server as ImapServer;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Message;
use Grace\Collabs\FileSystemSymfony;

class Reader
{
    const NO_EMAIL_FOUND = false;

    /** @var \Ddeboer\Imap\Connection */
    protected $connection;
    protected $rejectFolder;
    protected $buildPath;
    protected $fs;

    public function __construct($hostname, $username, $password, $rejectFolder, $buildPath)
    {
        $server = new ImapServer($hostname, $port = 993, $flags = '/imap/ssl/validate-cert');
        $this->connection = $server->authenticate($username, $password);
        $this->buildPath = $buildPath;
        $this->fs = new FileSystemSymfony();

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
            ->getMessages(new SearchExpression())
            ->current()
        ;

        if ($result->hasAttachments()) {
            $attachments = $result->getAttachments();

            foreach ($attachments as $attachment) {
                if (preg_match('/^.*\.zip$/i', $attachment->getFilename())) {
                    $unzipDir = $this->buildPath.'/'.uniqid('emailpatch_');
                    $this->fs->mkdir($unzipDir);

                    $zipFilename = $unzipDir.'/'.$attachment->getFilename();
                    file_put_contents(
                        $zipFilename,
                        $attachment->getDecodedContent()
                    );

                    return new MailInput($result->getSubject(), $zipFilename);
                }
            }
        }

        $result->move($this->rejectFolder);

        return self::NO_EMAIL_FOUND;
    }
}

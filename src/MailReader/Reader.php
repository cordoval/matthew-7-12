<?php

namespace Grace\MailReader;

use Ddeboer\Imap\Mailbox;
use Ddeboer\Imap\SearchExpression;

class Reader
{
    protected $mailBox;
    protected $search;


    public function __construct(Mailbox $mailBox = null)
    {
        $this->mailBox = $mailBox;
    }

    public function setMailbox(Mailbox $mailBox)
    {
        $this->mailBox = $mailBox;
        return $this;
    }

    public function setSearchNoFlagPushed()
    {
        $messages = $this->mailBox->getMessages(new SearchExpression(' UNFLAGGED "PUSHED"'));
        return $messages->current();
    }
}
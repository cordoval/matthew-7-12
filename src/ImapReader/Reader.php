<?php

namespace Grace\ImapReader;

class Reader {
    protected $mailAccount;
    protected $user;
    protected $password;
    protected $mailboxmsginfo;

    protected $mailbox;

    public function __construct($mailAccount, $user, $password)
    {
        $this->mailAccount = $mailAccount;
        $this->user = $user;
        $this->password = $password;
    }

    public function open()
    {
        $this->mailbox = imap_open(
            $this->$mailAccount,
            $this->user,
            $this->password);

        return $this->mailbox;
    }

    public function mailboxmsginfo()
    {
        return imap_mailboxmsginfo($this->mailbox);
    }

    /**
     * read and email
     */
    public function readMail($number){

    }

    public static function callback($mailAccount, $user, $password)
    {
        $reader = new self($mailAccount, $user, $password);
        $mailbox = $reader->open();
        $mailboxmsginfo = $reader->mailboxmsginfo();

        if(!($mailboxmsginfo->Unread > 0)) { //tail or stack ???
            return false;
        }
        return = $reader->getLastMessageUID(1);
    }
} 
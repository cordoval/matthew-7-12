<?php

namespace Grace\ImapReader;

class Reader {
    protected $mailAccount;
    protected $user;
    protected $password;

    public function __construct()
    {
        $this->mailAccount;
        $this->user;
        $this->password;
    }

    public static function callback()
    {
        $mbx = imap_open($mailbox , $user , $password);
        $ck = imap_check($mbx);
        $mails = imap_fetch_overview($mbx,"1:5");
    }
} 
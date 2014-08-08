<?php

namespace Grace\ImapReader;

class Reader extends \Horde_Imap_Client_Socket
{
    protected $mailAccount;
    protected $user;
    protected $password;
    protected $mailboxmsginfo;

    protected $mailbox;

    public static function callback($settings = array())
    {
        $reader = new self($settings);
    }
} 
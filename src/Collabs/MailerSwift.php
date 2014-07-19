<?php

namespace Grace\Collabs;

class MailerSwift implements Mailer
{
    protected $mail;

    public function send()
    {
        return $this->mail;
    }

    public function receive()
    {
        return $this->mail;
    }

    public function create(array $list)
    {
        return $this->mail;
    }

    public function attach($zipFile)
    {
        return $this->mail;
    }
}

<?php

namespace Grace\MailReader;

class Reader
{
    protected $messages;


    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    public function readSubjects()
    {
        foreach ($this->messages as $message) {
            $headers[] = $message->getSubject();
        }
        return $headers;
    }
}   
<?php

namespace Grace\Collabs;

class MailerSwift implements Mailer
{
    protected $mail;
    protected $from;

    public function __construct($from)
    {
        $this->from;
    }

    public function send()
    {
        return $this->mail;
    }

    public function receive()
    {
        return $this->mail;
    }

    /**
     * @param array $list
     *
     * @return \Swift_Message
     */
    public function create(array $list)
    {
        return \Swift_Message::newInstance()
            ->setSubject('Outgoing email')
            ->setFrom($this->from)
            ->setTo($list)
            ->setBody(
                'Attached are the code updates'
            )
        ;
    }

    public function attach($zipFile)
    {
        // ->attach(Swift_Attachment::fromPath('my-document.pdf'))
    }

    public static function callback(array $list, array $manyCompressed, $from)
    {
        foreach ($manyCompressed as $zipFile) {
            (new self(
                    $from
                )
            )
                ->create($list)
                ->attach($zipFile)
                ->send()
            ;
        }

        return true;
    }
}

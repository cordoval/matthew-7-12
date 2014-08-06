<?php

namespace Grace\Collabs;

use Swift_Attachment;

class MailerSwift implements Mailer
{
    protected $baseMailer;
    protected $from;

    public function __construct($from, \Swift_Mailer $baseMailer)
    {
        $this->from;
        $this->baseMailer;
    }

    /**
     * @param array $list
     *
     * @return \Swift_Message
     */
    public function create(array $list, $zipFile)
    {
        return \Swift_Message::newInstance()
            ->setSubject('Outgoing email')
            ->setFrom($this->from)
            ->setTo($list)
            ->attach(Swift_Attachment::fromPath($zipFile))
            ->setBody(
                'Attached are the code updates'
            )
        ;
    }

    public function send($message)
    {
        $this->baseMailer->send($message);
    }

    public static function callback(array $list, array $manyCompressed, $from, $baseMailer)
    {
        $mailer = new self($from, $baseMailer);
        foreach ($manyCompressed as $zipFile) {
            $message = $mailer->create($list, $zipFile);
            $mailer->send($message);
        }

        return true;
    }
}

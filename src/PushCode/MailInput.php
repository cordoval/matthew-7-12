<?php

namespace Grace\PushCode;


class MailInput
{
    protected $attachment;
    protected $vendor;
    protected $reponame;

    public function __construct($subject, $attachment)
    {
        $this->subject = $subject;
        $this->attachment = $attachment;

        $vendorRepo = (explode('/', explode(':', $subject)[1]));
        $this->vendor = $vendorRepo[0];
        $this->reponame = explode('.',$vendorRepo[1])[0];

    }

    public function getAttachment()
    {
        return $this->attachment;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getRepoName()
    {
        return $this->reponame;
    }
} 
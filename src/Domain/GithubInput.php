<?php

namespace Grace\Domain;

class GithubInput extends BaseDomain implements HookPost
{
    protected $vendor;
    protected $name;
    protected $from;

    public static function fromEmailSubject($githubUser, $emailSubject)
    {
        $fromName = (explode('/', explode(':', $emailSubject)[1]));
        $hook = new self();
        $hook->vendor = $githubUser;
        $hook->from = $fromName[0];
        $hook->name = explode('.',$fromName[1])[0];

        return $hook;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getName()
    {
        return $this->name;
    }
}

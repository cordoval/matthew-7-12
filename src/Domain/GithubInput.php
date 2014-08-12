<?php

namespace Grace\Domain;

class GithubInput extends BaseDomain implements HookPost
{
    protected $vendor;
    protected $name;
<<<<<<< HEAD
    protected $from;

    public static function fromEmailSubject($githubUser, $emailSubject)
    {
        $fromName = (explode('/', explode(':', $emailSubject)[1]));
        $hook = new self();
        $hook->vendor = $githubUser;
        $hook->from = $fromName[0];
        $hook->name = explode('.',$fromName[1])[0];
=======

    public static function fromEmailSubject($emailSubject)
    {
        $vendorName = (explode('/', explode(':', $emailSubject)[1]));
        $hook = new self();
        $hook->vendor = $vendorName[0];
        $hook->name = explode('.', $vendorName[1])[0];
>>>>>>> b11ef452068ce253537341a04a3bac961fa6187f

        return $hook;
    }

    public function getFrom()
    {
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

<?php

namespace Grace\Domain;

class GithubInput extends BaseDomain implements HookPost
{
    protected $vendor;
    protected $name;

    public static function fromEmailSubject($emailSubject)
    {
        $vendorName = (explode('/', explode(':', $emailSubject)[1]));
        $hook = new self();
        $hook->vendor = $vendorName[0];
        $hook->name = explode('.',$vendorName[1])[0];

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

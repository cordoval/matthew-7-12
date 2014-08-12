<?php

namespace Grace\Domain;

class X extends BaseDomain implements HookPost
{
    protected $from;
    protected $to;
    protected $vendor;
    protected $name;

    public static function fromEmailSubject($repoAndPatch)
    {
        $vendorName = (explode('/', explode(':', $repoAndPatch['repo'])[1]));

        $x = new self();
        $x->from = null;
        $x->to = null;
        $x->vendor = $vendorName[0];
        $x->name = explode('.', $vendorName[1])[0];

        return $x;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
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

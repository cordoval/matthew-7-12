<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class GithubPost extends BaseDomain implements HookPost
{
    protected $from;
    protected $to;
    protected $vendor;
    protected $name;

    public static function fromRequest(Request $request)
    {
        $content = (array) $request->getContent();

        $hook = new self();
        $hook->from = $content['before'];
        $hook->to = $content['after'];
        $hook->vendor = $content['repository']['owner']['name'];
        $hook->name = $content['repository']['name'];

        return $hook;
    }

    public static function fromEmail($repoAndPatch)
    {
        $hook = new self();
        $hook->from;
        $hook->to;
        $hook->vendor;
        $hook->name;

        return $hook;
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

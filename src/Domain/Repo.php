<?php

namespace Grace\Domain;

class Repo extends BaseDomain
{
    protected $hookPost;

    public static function from($changeSet)
    {

    }

    public static function fromHook(HookPost $hookPost)
    {
        $repo = new self;
        $repo->hookPost = $hookPost;

        return $repo;
    }

    /**
     * @return HookPost
     */
    public function getHookPost()
    {
        return $this->hookPost;
    }

    public function getBaseUrl()
    {
        return 'github.com';
    }
}

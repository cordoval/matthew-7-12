<?php

namespace Grace\Domain;

class MailList extends BaseDomain
{
    protected $addresses;

    public static function from($repo)
    {
        $list = new self();
        $list->addresses = ['cordoval@gmail.com', 'ysramirez@gmail.com'];

        return $list;
    }
}

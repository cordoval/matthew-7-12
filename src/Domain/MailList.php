<?php

namespace Grace\Domain;

class MailList extends BaseDomain
{
    public static function from($repo)
    {
        $list = new self;
        $list->metadata = fn($repo);

        return $list;
    }

    public static function withPayload($list, $payloadSet)
    {
        $mailList = new self;
        $mailList->metadata = fn($list, $payloadSet);

        return $mailList;
    }
}

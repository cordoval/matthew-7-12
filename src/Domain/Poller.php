<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Poller extends \Horde_Imap_Client_Socket
{
    public function searchFirstUnpushed($box)
    {
        $searchQuery = new \Horde_Imap_Client_Search_Query;
        $searchQuery->flag('Pushed', false);
        $result = $this->search($box, $searchQuery)['match']->__get("ids")[0];

        return $result;
    }

    public static function pollFromNotification($imapConnection)
    {
        return new self($imapConnection);
    }
}
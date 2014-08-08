<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class Poller extends \Horde_Imap_Client_Socket
{
    public function searchFirstUnpushed($box){
        $searchQuery = new \Horde_Imap_Client_Search_Query;
        $searchQuery->flag('Pushed', false);
        return $this->search($box, $searchQuery);
    }

    public static function pollFromNotification($imapConnection)
    {
        return new self($imapConnection);
    }
}
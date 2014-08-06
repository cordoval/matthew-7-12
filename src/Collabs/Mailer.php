<?php

namespace Grace\Collabs;

interface Mailer
{
    public function create(array $list, $zipFile);
    public function send($message);
}

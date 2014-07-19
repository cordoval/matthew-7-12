<?php

namespace Grace\Collabs;

interface Mailer
{
    public function send();
    public function receive();
    public function create(array $list);
    public function attach($zipFile);
}

<?php

namespace Grace\Collabs;

use Github\Client;

class Githubapi
{
    protected $client;

    public function __construct($username, $password)
    {
        $client = new Client();
        $client->authenticate($username, $password, \Github\Client::AUTH_HTTP_PASSWORD);
    }

    public function fork($vendor, $repo)
    {
        return $client->api('repo')->forks()->create($vendor, $repo);
    }
} 
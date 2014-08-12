<?php

namespace Grace\Collabs;

use Github\Client;

class GitHubClient
{
    protected $client;

    public function __construct($username, $password)
    {
        $this->client = new Client();
        $this->client->authenticate($username, $password, Client::AUTH_HTTP_PASSWORD);
    }

    public function fork($vendor, $repo)
    {
        return $this->client->api('repo')->forks()->create($vendor, $repo);
    }
}

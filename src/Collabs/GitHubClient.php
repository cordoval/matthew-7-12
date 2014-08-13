<?php

namespace Grace\Collabs;

use Github\Client;

class GitHubClient
{
    protected $client;
    protected $username;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->client = new Client();
        $this->client->authenticate($username, $password, Client::AUTH_HTTP_PASSWORD);
    }

    public function fork($vendor, $reponame)
    {
        return $this->client->api('repo')->forks()->create($vendor, $reponame);
    }

    public function pullRequest($vendor, $reponame)
    {
        return $this->client->api('pull_request')->create(
            $vendor,
            $reponame,
            [
                'base'  => 'master',
                'head'  => sprintf('%s:master', $this->username),
                'title' => 'PR from Matthew-7-12',
                'body' => 'This is a PR from Matthew 7-12',
            ]
        );
    }
}

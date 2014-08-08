<?php

namespace Grace\Domain;

class GithubPush
{
    protected $messages;

    public function __construct()
    {

    }

    public function createRepos($gitRepos)
    {
        foreach($gitRepos as $repo){
            /*
             * check if the $repo is a valid git repo
             * clone the repo
             * set the response of the repos
             */
        }
    }

} 
<?php

namespace Grace\Domain;

use Symfony\Component\HttpFoundation\Request;

class GithubPost extends BaseDomain implements HookPost
{
    protected $from;
    protected $to;
    protected $vendor;
    protected $name;

    public static function fromRequest(Request $request)
    {
        $content = $request->getContent();

        $hook = new self;
        $hook->from = $content['before'];
        $hook->to = $content['after'];
        $hook->vendor = $content['repository']['owner']['name'];
        $hook->name = $content['repository']['name'];

        return $hook;
    }
}

//{
//  "ref": "refs/heads/gh-pages",
//  "after": "993b46bdfc03ae59434816829162829e67c4d490",
//  "before": "1c1e5d3e4551408b6f2818492425b882c4c434cb",
//  "created": false,
//  "deleted": false,
//  "forced": false,
//  "compare": "https://github.com/baxterthehacker/public-repo/compare/1c1e5d3e4551...993b46bdfc03",
//  "commits": [
//    {
//        "id": "993b46bdfc03ae59434816829162829e67c4d490",
//      "distinct": true,
//      "message": "Trigger pages build",
//      "timestamp": "2014-07-01T13:21:13-04:00",
//      "url": "https://github.com/baxterthehacker/public-repo/commit/993b46bdfc03ae59434816829162829e67c4d490",
//      "author": {
//        "name": "Kyle Daigle",
//        "email": "kyle.daigle@github.com",
//        "username": "kdaigle"
//      },
//      "committer": {
//        "name": "Kyle Daigle",
//        "email": "kyle.daigle@github.com",
//        "username": "kdaigle"
//      },
//      "added": [
//
//    ],
//      "removed": [
//
//    ],
//      "modified": [
//        "index.html"
//    ]
//    }
//  ],
//  "head_commit": {
//        "id": "993b46bdfc03ae59434816829162829e67c4d490",
//    "distinct": true,
//    "message": "Trigger pages build",
//    "timestamp": "2014-07-01T13:21:13-04:00",
//    "url": "https://github.com/baxterthehacker/public-repo/commit/993b46bdfc03ae59434816829162829e67c4d490",
//    "author": {
//            "name": "Kyle Daigle",
//      "email": "kyle.daigle@github.com",
//      "username": "kdaigle"
//    },
//    "committer": {
//            "name": "Kyle Daigle",
//      "email": "kyle.daigle@github.com",
//      "username": "kdaigle"
//    },
//    "added": [
//
//        ],
//    "removed": [
//
//        ],
//    "modified": [
//            "index.html"
//        ]
//  },
//  "repository": {
//        "id": 20000106,
//    "name": "public-repo",
//    "url": "https://github.com/baxterthehacker/public-repo",
//    "description": "",
//    "watchers": 0,
//    "stargazers": 0,
//    "forks": 0,
//    "fork": false,
//    "size": 569,
//    "owner": {
//            "name": "baxterthehacker",
//      "email": "baxterthehacker@users.noreply.github.com"
//    },
//    "private": false,
//    "open_issues": 23,
//    "has_issues": true,
//    "has_downloads": true,
//    "has_wiki": true,
//    "created_at": 1400625583,
//    "pushed_at": 1404235275,
//    "master_branch": "master"
//  },
//  "pusher": {
//        "name": "baxterthehacker",
//    "email": "baxterthehacker@users.noreply.github.com"
//  }
//}
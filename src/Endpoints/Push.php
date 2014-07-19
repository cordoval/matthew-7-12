<?php

use Grace\PushCode\Flow;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Push
{
    protected $flow;

    public function __construct(Flow $flow)
    {
        $this->flow = $flow;
    }

    public function push(Request $request)
    {
        $this->flow->push($request);

        return new Response('received', Response::HTTP_OK);
    }
}
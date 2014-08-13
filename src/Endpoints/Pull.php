<?php

namespace Grace\Endpoints;

use Grace\PullCode\Flow;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Pull
{
    protected $flow;

    public function __construct(Flow $flow)
    {
        $this->flow = $flow;
    }

    public function __invoke(Request $request)
    {
        $this->flow->pull($request);

        return new Response('received', Response::HTTP_OK);
    }
}

<?php

namespace Grace\Endpoints;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Welcome
{
    public function __invoke(Request $request)
    {
        return new Response('welcome', Response::HTTP_OK);
    }
}

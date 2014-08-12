<?php

namespace Grace\PushCode;

class Flow
{
    protected $usherer;

    public function __construct(
        Usherer $usherer
    ) {
        $this->usherer = $usherer;
    }

    public function push($request)
    {
        $usherer = $this->usherer;
    }
}

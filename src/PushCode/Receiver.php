<?php

namespace Grace;

interface Receiver
{
    public function __invoke($request);
}

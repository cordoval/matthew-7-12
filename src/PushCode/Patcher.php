<?php

namespace Grace;

interface Patcher
{
    public function __invoke($patch);
}

<?php

namespace Grace\Collabs;

class Collab
{
    protected $callback;

    public function __invoke()
    {
        return call_user_func_array(
            [
                $this->callback['class'],
                $this->callback['method'],
            ],
            func_get_args()
        );
    }

    public function setCallback(array $callback)
    {
        $this->callback = $callback;
    }
}

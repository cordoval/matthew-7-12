<?php

namespace Grace\Collabs;

trait ContainerAwareTrait
{
    protected $container;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}

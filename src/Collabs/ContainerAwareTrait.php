<?php

namespace Grace\Collabs;

trait ContainerAwareTrait
{
    /** @var Container */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}

<?php

namespace Grace\UseCases;

class PullCodeTest extends BaseProphecy
{
    /**
     * @test
     */
    public function it_should_dispatch_job_for_received()
    {
        $collabs = $this->prophesy('Usherer');
        $this->assertTrue(true);
    }
}
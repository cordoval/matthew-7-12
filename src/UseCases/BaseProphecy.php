<?php

namespace UseCases;

use Prophecy\Prophet;

class BaseProphecy extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    protected $prophet;

    public function prophesy($classOrInterface)
    {
        return $this->prophet->prophesize($classOrInterface);
    }

    protected function setup()
    {
        $this->prophet = new Prophet;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}

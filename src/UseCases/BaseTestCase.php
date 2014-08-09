<?php

namespace Grace\UseCases;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{
    protected static function getKernelClass()
    {
        return 'Grace\\AppKernel';
    }
}
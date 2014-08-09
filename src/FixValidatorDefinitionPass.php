<?php

namespace Grace;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FixValidatorDefinitionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('validator')->setClass('Symfony\Component\Validator\Validator');
    }
}

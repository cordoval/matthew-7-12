<?php

namespace Grace;

use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;

class CliApplication extends BaseApplication
{
    protected function registerCommands()
    {
        $container = $this->getKernel()->getContainer();

        if ($container->hasParameter('console.command.ids')) {
            foreach ($container->getParameter('console.command.ids') as $id) {
                $this->add($container->get($id));
            }
        }

        $this->addCommands($this->getKernel()->getCommands());
    }
}

<?php

namespace Grace;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Bundle\FrameworkBundle\Command as SymfonyCommand;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\Command\DebugCommand;
use Symfony\Bundle\SwiftmailerBundle\Command\NewEmailCommand;
use Symfony\Bundle\SwiftmailerBundle\Command\SendEmailCommand;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new MonologBundle(),
            new SwiftmailerBundle(),
            new AsseticBundle(),
            new DoctrineBundle(),
            new WebProfilerBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/../app/config/config_'.$this->getEnvironment().'.yml');

        if (is_file($file = __DIR__.'/../app/config/config_'.$this->environment.'.local.yml')) {
            $loader->load($file);
        }
    }

    public function getCacheDir()
    {
        return __DIR__.'/../app/cache';
    }

    public function getLogDir()
    {
        return __DIR__.'/../app/logs';
    }

    public function getCommands()
    {
        $commands = [
            new SymfonyCommand\CacheClearCommand(),
            new SymfonyCommand\CacheWarmupCommand(),
            new SymfonyCommand\ConfigDumpReferenceCommand(),
            new SymfonyCommand\ContainerDebugCommand(),
            new SymfonyCommand\RouterDebugCommand(),
            new SymfonyCommand\RouterMatchCommand(),
            new SymfonyCommand\ServerRunCommand(),
            new DebugCommand(),
            new NewEmailCommand(),
            new SendEmailCommand(),
        ];

        foreach ($commands as $command) {
            if ($command instanceof SymfonyCommand\ContainerAwareCommand) {
                $command->setContainer($this->getContainer());
            }
        }

        return $commands;
    }
}

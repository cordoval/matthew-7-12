<?php

namespace Grace;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Matthias\SymfonyServiceDefinitionValidator\Compiler\ValidateServiceDefinitionsPass;
use Matthias\SymfonyServiceDefinitionValidator\Configuration;
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
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;
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

    protected function prepareContainer(ContainerBuilder $container)
    {
        $extensions = array();
        foreach ($this->bundles as $bundle) {
            if ($extension = $bundle->getContainerExtension()) {
                $container->registerExtension($extension);
                $extensions[] = $extension->getAlias();
            }

            if ($this->debug) {
                $container->addObjectResource($bundle);
            }
        }
        foreach ($this->bundles as $bundle) {
            $bundle->build($container);
        }

        $this->buildBundleless($container);

        // ensure these extensions are implicitly loaded
        $container->getCompilerPassConfig()->setMergePass(new MergeExtensionConfigurationPass($extensions));
    }

    private function buildBundleless(ContainerBuilder $container)
    {
        if ($container->getParameter('kernel.debug')) {
            $container->addCompilerPass(new FixValidatorDefinitionPass());

            $configuration = new Configuration();
            $configuration->setEvaluateExpressions(true);
            $container->addCompilerPass(
                new ValidateServiceDefinitionsPass($configuration),
                PassConfig::TYPE_AFTER_REMOVING
            );
        }
    }
}

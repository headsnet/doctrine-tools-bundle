<?php

namespace Headsnet\DoctrineToolsBundle;

use Headsnet\DoctrineToolsBundle\CustomTypes\RegisterDoctrineTypesCompilerPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class HeadsnetDoctrineToolsBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->arrayNode('custom_types')
            ->children()
            ->arrayNode('scan_dirs')
            ->scalarPrototype()->end()
            ->end()
            ->end()
            ->end()
            ->end()
        ;
    }

    /**
     * @param array{custom_types: array{scan_dirs: array<string>}} $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->parameters()
            ->set('headsnet_doctrine_tools.custom_types.scan_dirs', $config['custom_types']['scan_dirs'])
        ;
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(
            new RegisterDoctrineTypesCompilerPass()
        );
    }
}

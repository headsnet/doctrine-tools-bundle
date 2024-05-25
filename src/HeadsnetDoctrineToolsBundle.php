<?php

namespace Headsnet\DoctrineToolsBundle;

use Headsnet\DoctrineToolsBundle\Mapping\CarbonTypeMappingsCompilerPass;
use Headsnet\DoctrineToolsBundle\Mapping\DoctrineTypeMappingsCompilerPass;
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
                ->end() // End custom_types
                ->arrayNode('carbon_types')
                    ->canBeDisabled()
                    ->children()
                        ->booleanNode('replace')->defaultTrue()->end()
                    ->end()
                ->end() // End carbon_types
        ;
    }

    /**
     * @param array{
     *     custom_types: array{scan_dirs: array<string>},
     *     carbon_types: array{enabled: boolean, replace: boolean}
     * } $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->parameters()
            ->set('headsnet_doctrine_tools.custom_types.scan_dirs', $config['custom_types']['scan_dirs'])
            ->set('headsnet_doctrine_tools.carbon_types.enabled', $config['carbon_types']['enabled'])
            ->set('headsnet_doctrine_tools.carbon_types.replace', $config['carbon_types']['replace'])
        ;
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(
            new DoctrineTypeMappingsCompilerPass()
        );

        $container->addCompilerPass(
            new CarbonTypeMappingsCompilerPass()
        );
    }
}

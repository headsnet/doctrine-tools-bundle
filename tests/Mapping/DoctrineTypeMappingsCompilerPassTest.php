<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Mapping;

use Headsnet\DoctrineToolsBundle\Mapping\DoctrineTypeMappingNamer;
use Headsnet\DoctrineToolsBundle\Mapping\DoctrineTypeMappingsCompilerPass;
use Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures\DummyCustomType;
use Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures\DummyCustomTypeWithName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(DoctrineTypeMappingsCompilerPass::class)]
#[CoversClass(DoctrineTypeMappingNamer::class)]
class DoctrineTypeMappingsCompilerPassTest extends TestCase
{
    #[Test]
    public function can_find_and_register_types(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', []);
        $container->setParameter('headsnet_doctrine_tools.custom_mappings.scan_dirs', [
            __DIR__ . '/Fixtures',
        ]);
        $sut = new DoctrineTypeMappingsCompilerPass();

        $sut->process($container);

        $result = $container->getParameter('doctrine.dbal.connection_factory.types');
        $expected = [
            'dummy_custom' => [
                'class' => DummyCustomType::class,
            ],
            'my_custom_name' => [
                'class' => DummyCustomTypeWithName::class,
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function ignores_types_that_are_manually_registered(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', [
            'dummy_custom' => [
                'class' => DummyCustomType::class,
            ],
        ]);
        $container->setParameter('headsnet_doctrine_tools.custom_mappings.scan_dirs', [
            __DIR__ . '/Fixtures',
        ]);
        $sut = new DoctrineTypeMappingsCompilerPass();

        $sut->process($container);

        $result = $container->getParameter('doctrine.dbal.connection_factory.types');
        $expected = [
            'dummy_custom' => [
                'class' => DummyCustomType::class,
            ],
            'my_custom_name' => [
                'class' => DummyCustomTypeWithName::class,
            ],
        ];
        $this->assertEquals($expected, $result);
    }
}

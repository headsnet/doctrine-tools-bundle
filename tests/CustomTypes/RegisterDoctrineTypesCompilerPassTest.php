<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CustomTypes;

use Headsnet\DoctrineToolsBundle\CustomTypes\CustomTypeNamer;
use Headsnet\DoctrineToolsBundle\CustomTypes\CustomTypesCompilerPass;
use Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures\DummyCustomType;
use Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures\DummyCustomTypeWithName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CustomTypesCompilerPass::class)]
#[CoversClass(CustomTypeNamer::class)]
class RegisterDoctrineTypesCompilerPassTest extends TestCase
{
    #[Test]
    public function can_find_and_register_types(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', []);
        $container->setParameter('headsnet_doctrine_tools.custom_types.scan_dirs', [
            __DIR__ . '/Fixtures',
        ]);
        $sut = new CustomTypesCompilerPass();

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
        $container->setParameter('headsnet_doctrine_tools.custom_types.scan_dirs', [
            __DIR__ . '/Fixtures',
        ]);
        $sut = new CustomTypesCompilerPass();

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

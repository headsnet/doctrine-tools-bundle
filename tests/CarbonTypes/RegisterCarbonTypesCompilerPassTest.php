<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CarbonTypes;

use Carbon\Doctrine\DateTimeImmutableType;
use Carbon\Doctrine\DateTimeType;
use Headsnet\DoctrineToolsBundle\CarbonTypes\CarbonTypesCompilerPass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CarbonTypesCompilerPass::class)]
class RegisterCarbonTypesCompilerPassTest extends TestCase
{
    #[Test]
    public function carbon_types_are_registered(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', []);
        $container->setParameter('headsnet_doctrine_tools.carbon_types.enabled', true);
        $container->setParameter('headsnet_doctrine_tools.carbon_types.replace', true);
        $sut = new CarbonTypesCompilerPass();

        $sut->process($container);

        $result = $container->getParameter('doctrine.dbal.connection_factory.types');
        $expected = [
            'datetime_immutable' => [
                'class' => DateTimeImmutableType::class,
            ],
            'datetime' => [
                'class' => DateTimeType::class,
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function carbon_types_are_registered_separately(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', []);
        $container->setParameter('headsnet_doctrine_tools.carbon_types.enabled', true);
        $container->setParameter('headsnet_doctrine_tools.carbon_types.replace', false);
        $sut = new CarbonTypesCompilerPass();

        $sut->process($container);

        $result = $container->getParameter('doctrine.dbal.connection_factory.types');
        $expected = [
            'carbon_immutable' => [
                'class' => DateTimeImmutableType::class,
            ],
            'carbon' => [
                'class' => DateTimeType::class,
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function if_disabled_then_register_nothing(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('doctrine.dbal.connection_factory.types', []);
        $container->setParameter('headsnet_doctrine_tools.carbon_types.enabled', false);
        $sut = new CarbonTypesCompilerPass();

        $sut->process($container);

        $result = $container->getParameter('doctrine.dbal.connection_factory.types');
        $expected = [];
        $this->assertEquals($expected, $result);
    }
}

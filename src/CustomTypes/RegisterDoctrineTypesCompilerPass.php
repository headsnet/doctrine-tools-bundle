<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\CustomTypes;

use Doctrine\DBAL\Types\Type;
use Generator;
use League\ConstructFinder\ConstructFinder;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This compiler pass automatically locates custom Doctrine types, and registers them with Doctrine.
 *
 * This saves having to specify them all individually in the Doctrine configuration which is tedious.
 */
final class RegisterDoctrineTypesCompilerPass implements CompilerPassInterface
{
    private const TYPE_DEFINITION_PARAMETER = 'doctrine.dbal.connection_factory.types';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter(self::TYPE_DEFINITION_PARAMETER)) {
            return;
        }

        /** @var array<string, array{class: class-string}> $typeDefinitions */
        $typeDefinitions = $container->getParameter(self::TYPE_DEFINITION_PARAMETER);
        /** @var array<string> $scanDirs */
        $scanDirs = $container->getParameter('headsnet_doctrine_tools.custom_types.scan_dirs');

        $types = $this->findTypesInApplication($scanDirs);

        foreach ($types as $type) {
            $name = $type['name'];
            $class = $type['class'];

            // Do not add the type if it's been manually defined already
            if (array_key_exists($name, $typeDefinitions)) {
                continue;
            }

            $typeDefinitions[$name] = [
                'class' => $class,
            ];
        }

        $container->setParameter(self::TYPE_DEFINITION_PARAMETER, $typeDefinitions);
    }

    /**
     * @param array<string> $scanDirs
     *
     * @return Generator<int, array{class: class-string, name: string}>
     */
    private function findTypesInApplication(array $scanDirs): iterable
    {
        $classNames = ConstructFinder::locatedIn(...$scanDirs)->findClassNames();

        foreach ($classNames as $className) {
            $reflection = new ReflectionClass($className);

            // If the class is not a Doctrine Type
            if (!$reflection->isSubclassOf(Type::class)) {
                continue;
            }

            // Skip any abstract parent types
            if ($reflection->isAbstract()) {
                continue;
            }

            // Only register types that have the #[CustomType] attribute
            if ($reflection->getAttributes(CustomType::class)) {
                yield [
                    'name' => CustomTypeNamer::getTypeName($reflection),
                    'class' => $className,
                ];
            }
        }
    }
}

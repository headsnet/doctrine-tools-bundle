<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\CustomTypes;

use Doctrine\DBAL\Types\Type;
use ReflectionClass;

/**
 * If the #[CustomType] attribute has a name specified, use it.
 *
 * Otherwise derive it from the class name - e.g. "CarbonDateType" => "carbon_date"
 */
final class CustomTypeNamer
{
    /**
     * @param ReflectionClass<Type> $reflection
     */
    public static function getTypeName(ReflectionClass $reflection): string
    {
        $attribute = $reflection->getAttributes(CustomType::class)[0];

        $attributeArgs = $attribute->getArguments();

        if (isset($attributeArgs['name'])) {
            return $attributeArgs['name'];
        }

        $typeName = str_replace('Type', '', $reflection->getShortName());
        $typeName = (string) preg_replace("/(?<=.)([A-Z])/", "_$1", $typeName);

        return strtolower($typeName);
    }
}

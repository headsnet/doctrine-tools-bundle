<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Headsnet\DoctrineToolsBundle\Attribute\DoctrineTypeMapping;

#[DoctrineTypeMapping]
abstract class AbstractCustomType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return '';
    }
}

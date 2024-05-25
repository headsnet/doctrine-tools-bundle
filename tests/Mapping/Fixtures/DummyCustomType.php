<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Headsnet\DoctrineToolsBundle\Attribute\DoctrineTypeMapping;

#[DoctrineTypeMapping]
class DummyCustomType extends AbstractCustomType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return '';
    }
}

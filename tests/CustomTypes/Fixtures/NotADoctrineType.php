<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Headsnet\DoctrineToolsBundle\CustomTypes\CustomType;

#[CustomType]
class NotADoctrineType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return '';
    }
}

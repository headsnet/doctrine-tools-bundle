<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Headsnet\DoctrineToolsBundle\Attribute\DoctrineTypeMapping;

#[DoctrineTypeMapping]
class NotADoctrineType
{
    /**
     * @param array{length?: int, fixed?: bool} $column
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return '';
    }
}

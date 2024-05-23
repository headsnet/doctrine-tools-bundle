<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Headsnet\DoctrineToolsBundle\CustomTypes\CustomType;

#[CustomType]
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

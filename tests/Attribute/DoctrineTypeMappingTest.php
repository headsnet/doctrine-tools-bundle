<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Attribute;

use Headsnet\DoctrineToolsBundle\Attribute\DoctrineTypeMapping;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DoctrineTypeMapping::class)]
class DoctrineTypeMappingTest extends TestCase
{
    #[Test]
    public function name_can_be_specified(): void
    {
        $sut = new DoctrineTypeMapping('custom_name');

        $this->assertEquals('custom_name', $sut->name);
    }

    #[Test]
    public function name_is_normalised(): void
    {
        $sut = new DoctrineTypeMapping('some-custom Name');

        $this->assertEquals('some_custom_name', $sut->name);
    }
}

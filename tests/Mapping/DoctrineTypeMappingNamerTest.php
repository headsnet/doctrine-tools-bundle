<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\Mapping;

use Headsnet\DoctrineToolsBundle\Mapping\DoctrineTypeMappingNamer;
use Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures\DummyCustomType;
use Headsnet\DoctrineToolsBundle\Tests\Mapping\Fixtures\DummyCustomTypeWithName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(DoctrineTypeMappingNamer::class)]
class DoctrineTypeMappingNamerTest extends TestCase
{
    #[Test]
    public function default_name_derived_from_class(): void
    {
        $reflection = new ReflectionClass(new DummyCustomType());

        $sut = DoctrineTypeMappingNamer::getTypeName($reflection);

        $this->assertEquals('dummy_custom', $sut);
    }

    #[Test]
    public function name_can_be_specified(): void
    {
        $reflection = new ReflectionClass(new DummyCustomTypeWithName());

        $sut = DoctrineTypeMappingNamer::getTypeName($reflection);

        $this->assertEquals('my_custom_name', $sut);
    }
}

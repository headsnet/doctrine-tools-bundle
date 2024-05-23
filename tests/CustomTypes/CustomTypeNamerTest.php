<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CustomTypes;

use Headsnet\DoctrineToolsBundle\CustomTypes\CustomTypeNamer;
use Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures\DummyCustomType;
use Headsnet\DoctrineToolsBundle\Tests\CustomTypes\Fixtures\DummyCustomTypeWithName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

#[CoversClass(CustomTypeNamer::class)]
class CustomTypeNamerTest extends TestCase
{
    #[Test]
    public function default_name_derived_from_class(): void
    {
        $reflection = new ReflectionClass(new DummyCustomType());

        $sut = CustomTypeNamer::getTypeName($reflection);

        $this->assertEquals('dummy_custom', $sut);
    }

    #[Test]
    public function name_can_be_specified(): void
    {
        $reflection = new ReflectionClass(new DummyCustomTypeWithName());

        $sut = CustomTypeNamer::getTypeName($reflection);

        $this->assertEquals('my_custom_name', $sut);
    }
}

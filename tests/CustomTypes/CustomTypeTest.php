<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Tests\CustomTypes;

use Headsnet\DoctrineToolsBundle\CustomTypes\CustomType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CustomType::class)]
class CustomTypeTest extends TestCase
{
    #[Test]
    public function name_can_be_specified(): void
    {
        $sut = new CustomType('custom_name');

        $this->assertEquals('custom_name', $sut->name);
    }

    #[Test]
    public function name_is_normalised(): void
    {
        $sut = new CustomType('some-custom Name');

        $this->assertEquals('some_custom_name', $sut->name);
    }
}

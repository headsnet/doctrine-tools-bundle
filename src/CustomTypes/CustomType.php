<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\CustomTypes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class CustomType
{
    public string $name;

    public function __construct(string $name = '')
    {
        $name = str_replace(' ', '_', $name);
        $name = str_replace('-', '_', $name);
        $this->name = strtolower($name);
    }
}

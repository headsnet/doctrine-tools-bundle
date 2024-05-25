<?php
declare(strict_types=1);

namespace Headsnet\DoctrineToolsBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class DoctrineTypeMapping
{
    public string $name;

    public function __construct(string $name = '')
    {
        $name = str_replace(' ', '_', $name);
        $name = str_replace('-', '_', $name);
        $this->name = strtolower($name);
    }
}

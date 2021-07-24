<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

interface MenuLoaderInterface
{
    public function load(string $section = null): ?array;
}
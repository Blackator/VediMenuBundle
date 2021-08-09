<?php

namespace Blackator\Bundle\VediMenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VediMenuBundle extends Bundle
{
    public function getPath()
    {
        return dirname(__DIR__);
    }

}
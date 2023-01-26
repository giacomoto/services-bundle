<?php

namespace Luckyseven\Bundle\LuckysevenServicesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LuckysevenServicesBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}

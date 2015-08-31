<?php

namespace Manudev\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ManudevUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

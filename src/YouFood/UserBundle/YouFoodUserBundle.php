<?php

namespace YouFood\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * YouFoodUserBundle
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class YouFoodUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}

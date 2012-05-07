<?php

namespace YouFood\MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * YouFoodMediaBundle
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class YouFoodMediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataMediaBundle';
    }
}

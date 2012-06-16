<?php

namespace YouFood\ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use JMS\SerializerBundle\SerializerBundleAwareInterface;
use JMS\SerializerBundle\DependencyInjection\JMSSerializerExtension;

use YouFood\ApiBundle\DependencyInjection\Factory\HandlerFactory;

/**
 * YouFoodApiBundle
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class YouFoodApiBundle extends Bundle implements SerializerBundleAwareInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureSerializerExtension(JMSSerializerExtension $extension)
    {
        $extension->addHandlerFactory(new HandlerFactory());
    }
}

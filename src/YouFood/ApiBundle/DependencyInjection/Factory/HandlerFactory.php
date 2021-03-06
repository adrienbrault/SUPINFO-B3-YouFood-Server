<?php

namespace YouFood\ApiBundle\DependencyInjection\Factory;

use JMS\SerializerBundle\DependencyInjection\HandlerFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * HandlerFactory
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class HandlerFactory implements HandlerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'you_food_api';
    }

    /**
     * {@inheritdoc}
     */
    public function getType(array $config)
    {
        return self::TYPE_SERIALIZATION;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getHandlerId(ContainerBuilder $container, array $config)
    {
        return 'you_food.api.serializer.handler';
    }
}
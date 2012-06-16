<?php

namespace YouFood\ApiBundle\Serializer;

use JMS\SerializerBundle\Serializer\Handler\SerializationHandlerInterface;
use JMS\SerializerBundle\Serializer\VisitorInterface;

use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\DependencyInjection\ContainerInterface;

use YouFood\MediaBundle\Entity\Media;
use YouFood\MainBundle\Entity\Order;
use YouFood\MainBundle\Entity\CollationOrder;
use YouFood\MainBundle\Entity\MenuOrder;

/**
 * Handler
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class Handler implements SerializationHandlerInterface
{
    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param Pool $pool
     */
    public function __construct(Pool $pool, ContainerInterface $container)
    {
        $this->pool = $pool;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(VisitorInterface $visitor, $data, $type, &$handled)
    {
        if ($data instanceof Media) {
            $this->fillMediaUrls($data);
        } else if ($data instanceof Order) {
            $this->fillOrderProducts($data);
        }
    }

    /**
     * @param Media $media
     */
    public function fillMediaUrls(Media $media)
    {
        $provider = $this->pool->getProvider($media->getProviderName());
        $assetsHelper = $this->container->get('templating.helper.assets'); /** @var $assetsHelper \Symfony\Component\Templating\Helper\CoreAssetsHelper */

        $smallPath = $provider->generatePublicUrl($media, $provider->getFormatName($media, 'small'));
        $bigPath = $provider->generatePublicUrl($media, $provider->getFormatName($media, 'big'));

        $media->setUrlSmall($assetsHelper->getUrl($smallPath));
        $media->setUrlBig($assetsHelper->getUrl($bigPath));
    }

    /**
     * @param Order $order
     */
    public function fillOrderProducts(Order $order)
    {
        $order->setCollationOrders($order->getProductOrders()->filter(function($productOrder) {
            return $productOrder instanceof CollationOrder;
        })->getValues());

        $order->setMenuOrders($order->getProductOrders()->filter(function($productOrder) {
            return $productOrder instanceof MenuOrder;
        })->getValues());
    }
}

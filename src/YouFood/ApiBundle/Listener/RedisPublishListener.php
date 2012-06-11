<?php

namespace YouFood\ApiBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use YouFood\MainBundle\Entity\Order;
use YouFood\MainBundle\Entity\Request;

/**
 * RedisPublishListener
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class RedisPublishListener
{
    /**
     * @var object
     */
    private $redis;

    /**
     * @param object $redis
     */
    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof Request) {
            $channel = sprintf('tables.%d.requests_%s', $entity->getTable()->getId(), $entity->getType());
            $this->redis->publish($channel, json_encode(array(
                'id' => $entity->getId(),
            )));
        } else if ($entity instanceof Order) {
            $this->redis->publish(sprintf('tables.%d.orders', $entity->getTable()->getId()), json_encode(array(
                'id' => $entity->getId(),
            )));
        }
    }
}

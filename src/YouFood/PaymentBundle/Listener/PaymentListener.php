<?php

namespace YouFood\PaymentBundle\Listener;

use Doctrine\ORM\EntityManager;

use JMS\Payment\CoreBundle\PluginController\Event\PaymentStateChangeEvent;
use JMS\Payment\CoreBundle\Model\PaymentInterface;

use YouFood\MainBundle\Repository\OrderRepository;

/**
 * PaymentListener
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class PaymentListener
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var object
     */
    private $redis;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, $redis)
    {
        $this->em = $em;
    }

    /**
     * @param PaymentStateChangeEvent $event
     */
    public function onPaymentStateChange(PaymentStateChangeEvent $event)
    {
        switch ($event->getNewState()) {
            case PaymentInterface::STATE_APPROVED: {
                $order = $this->em->getRepository('YouFoodMainBundle:Order')->findOneByPaymentInstruction($event->getPaymentInstruction());

                $order->setPaid(true);
                $this->em->flush($order);

                $this->redis->publish(sprintf('tables.%d.orders', $order->getTable()->getId()), json_encode(array(
                    'id' => $order->getId(),
                )));
            } break;
        }
    }
}

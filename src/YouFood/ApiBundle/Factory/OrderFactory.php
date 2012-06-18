<?php

namespace YouFood\ApiBundle\Factory;

use YouFood\ApiBundle\Model\Order as OrderModel;
use YouFood\MainBundle\Entity\Order;
use YouFood\MainBundle\Entity\ProductOrder;
use YouFood\MainBundle\Entity\CollationOrder;
use YouFood\MainBundle\Entity\MenuOrder;
use YouFood\MainBundle\Entity\Collation;
use YouFood\MainBundle\Entity\Menu;
use YouFood\MainBundle\Entity\MenuHasCollation;

/**
 * OrderFactory
 *
 * This factory creates Order's entity.
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class OrderFactory
{
    /**
     * @param OrderModel $orderModel
     *
     * @return Order
     */
    public function create(OrderModel $orderModel)
    {
        $amount = 0.0;

        $collationsOrders = array();
        foreach ($orderModel->getCollations() as $collation) { /** @var $collation Collation */
            $collationOrder = new CollationOrder();
            $collationOrder->setCollation($collation);
            $collationOrder->setPrice($collation->getPrice());

            $collationsOrders[] = $collationOrder;
            $amount += $collation->getPrice();
        }

        $menusOrders = array();
        foreach ($orderModel->getMenus() as $menu) { /** @var $menu Menu */
            $menuOrder = new MenuOrder();
            $menuOrder->setMenu($menu);
            $menuOrder->setPrice($menu->getPrice());

            $menusOrders[] = $menuOrder;
            $amount += $menu->getPrice();
        }

        $order = new Order();
        $order->setAmount($amount);
        $order->setTable($orderModel->getTable());
        foreach (array_merge($collationsOrders, $menusOrders) as $productOrder) { /** @var $productOrder ProductOrder */
            $order->addProductsOrders($productOrder);
        }

        return $order;
    }
}

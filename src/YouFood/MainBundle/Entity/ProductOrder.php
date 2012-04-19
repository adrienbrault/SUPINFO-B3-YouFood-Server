<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOrder
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\ProductOrderRepository")
 * @ORM\Table(name="product_orders")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *      "collation_order" = "CollationOrder",
 *      "menu_order" = "MenuOrder"
 * })
 */
class ProductOrder
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="productOrders", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $order;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}

<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
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
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductOrder", mappedBy="order", cascade={"all"}, orphanRemoval=true)
     */
    private $productOrders;

    /**
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $restaurant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productOrders = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return ArrayCollection
     */
    public function getProductOrders()
    {
        return $this->productOrders;
    }

    /**
     * @param Restaurant $restaurant
     */
    public function setRestaurant(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}

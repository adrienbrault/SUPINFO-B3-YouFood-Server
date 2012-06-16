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
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductOrder", mappedBy="order", cascade={"all"}, orphanRemoval=true)
     */
    private $productOrders;

    /**
     * @var Table
     *
     * @ORM\ManyToOne(targetEntity="Table")
     * @ORM\JoinColumn(name="tables_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $table;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $served;

    /**
     * @var array
     */
    private $collationOrders;

    /**
     * @var array
     */
    private $menuOrders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->productOrders = new ArrayCollection();
        $this->paid = false;
        $this->served = false;
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
     * @param \Traversable|array $productOrders
     */
    public function setProductOrders($productOrders)
    {
        $this->productOrders->clear();

        foreach ($productOrders as $productOrder) { /** @var $productOrder ProductOrder */
            $productOrder->setOrder($this);
            $this->productOrders[] = $productOrder;
        }
    }

    /**
     * @param ProductOrder $productOrder
     */
    public function addProductsOrders(ProductOrder $productOrder)
    {
        $productOrder->setOrder($this);
        $this->productOrders[] = $productOrder;
    }

    /**
     * @param Table $table
     */
    public function setTable(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param boolean $served
     */
    public function setServed($served)
    {
        $this->served = $served;
    }

    /**
     * @return boolean
     */
    public function getServed()
    {
        return $this->served;
    }

    /**
     * @return array
     */
    public function getCollationOrders()
    {
        return $this->collationOrders;
    }

    /**
     * @return array
     */
    public function getMenuOrders()
    {
        return $this->menuOrders;
    }

    /**
     * @param array $collationOrders
     */
    public function setCollationOrders($collationOrders)
    {
        $this->collationOrders = $collationOrders;
    }

    /**
     * @param array $menuOrders
     */
    public function setMenuOrders($menuOrders)
    {
        $this->menuOrders = $menuOrders;
    }
}

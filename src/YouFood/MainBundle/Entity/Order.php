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
     * @var Table
     *
     * @ORM\ManyToOne(targetEntity="Table")
     * @ORM\JoinColumn(name="tables_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $table;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
}

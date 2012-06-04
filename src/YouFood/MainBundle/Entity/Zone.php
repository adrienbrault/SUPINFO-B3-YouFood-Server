<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use YouFood\UserBundle\Entity\User;

/**
 * Zone
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\ZoneRepository")
 * @ORM\Table(name="zones")
 */
class Zone
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
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="zones", cascade={"persist"})
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $restaurant;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Table", mappedBy="zone", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $tables;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="YouFood\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="waiter_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $waiter;

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param ArrayCollection $tables
     */
    public function setTables($tables)
    {
        foreach ($tables as $table) {
            $table->setZone($this);
        }

        $this->tables = $tables;
    }

    /**
     * @return ArrayCollection
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table $table
     */
    public function addTables(Table $table)
    {
        $table->setZone($this);

        $this->tables[] = $table;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (strlen($this->name) == 0) {
            return (string) $this->getId();
        }

        return $this->name;
    }

    /**
     * @param User $waiter
     */
    public function setWaiter($waiter)
    {
        $this->waiter = $waiter;
    }

    /**
     * @return User
     */
    public function getWaiter()
    {
        return $this->waiter;
    }
}

<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Zone
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\ZoneRepository")
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
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="zones")
     */
    private $restaurant;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Table", mappedBy="zone")
     */
    private $tables;

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
        // Update inverse side
        if (null !== $this->restaurant) {
            $this->restaurant->getZones()->removeElement($this);
        }

        if (null !== $restaurant) {
            $restaurant->getZones()->add($this);
        }

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
        return (string) $this->getId();
    }

    /**
     * @return ArrayCollection
     */
    public function getTables()
    {
        return $this->tables;
    }
}

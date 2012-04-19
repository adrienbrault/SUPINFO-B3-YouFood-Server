<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Restaurant
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\RestaurantRepository")
 * @ORM\Table(name="restaurants")
 */
class Restaurant
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Zone", mappedBy="restaurant", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $zones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zones = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return ArrayCollection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * @param ArrayCollection $zones
     */
    public function setZones($zones)
    {
        if (is_array($zones)) {
            $zones = new ArrayCollection($zones);
        }

        foreach ($zones as $zone) {
            $zone->setRestaurant($this);
        }

        $this->zones = $zones;
    }

    /**
     * @param Zone $zone
     */
    public function addZones(Zone $zone)
    {
        $zone->setRestaurant($this);

        $this->zones[] = $zone;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCity() . $this->getAddress();
    }
}

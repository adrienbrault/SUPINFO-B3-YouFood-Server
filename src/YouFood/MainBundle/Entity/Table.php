<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Table
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\TableRepository")
 * @ORM\Table(name="tables")
 */
class Table
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var Zone
     *
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="table", cascade={"persist"})
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $zone;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param Zone $zone
     */
    public function setZone(Zone $zone)
    {
        $this->zone = $zone;
    }

    /**
     * @return Zone
     */
    public function getZone()
    {
        return $this->zone;
    }
}

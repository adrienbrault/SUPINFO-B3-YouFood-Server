<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var Zone
     *
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="tables")
     */
    private $zone;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Zone $zone
     */
    public function setZone(Zone $zone)
    {
        // Update inverse side
        if (null !== $this->zone) {
            $this->zone->getTables()->removeElement($this);
        }

        if (null !== $zone) {
            $zone->getTables()->add($this);
        }

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

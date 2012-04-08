<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationRepository")
 */
class Menu extends Product
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Collation")
     */
    private $collations;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->collations = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCollations()
    {
        return $this->collations;
    }

    /**
     * @param Collation $collation
     */
    public function addCollation(Collation $collation)
    {
        $this->collations[] = $collation;
    }
}

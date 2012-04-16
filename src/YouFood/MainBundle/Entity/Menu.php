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
     * @ORM\OneToMany(targetEntity="MenuCollation", mappedBy="menu", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $menuCollations;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->menuCollations = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getMenuCollations()
    {
        return $this->menuCollations;
    }

    /**
     * @param ArrayCollection $menuCollations
     */
    public function setMenuCollations($menuCollations)
    {
        foreach ($menuCollations as $menuCollation) {
            $menuCollation->setMenu($this);
        }

        $this->menuCollations = $menuCollations;
    }

    public function addMenuCollations(MenuCollation $menuCollation)
    {
        $menuCollation->setMenu($this);

        $this->menuCollations[] = $menuCollation;
    }
}

<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MenuOrder
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\MenuOrderRepository")
 */
class MenuOrder extends ProductOrder
{
    /**
     * @var Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu")
     */
    private $menu;

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
        $this->collations = new ArrayCollection();
    }

    /**
     * @param Menu $menu
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return Menu
     */
    public function getMenu()
    {
        return $this->menu;
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

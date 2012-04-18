<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuCollation
 *
 * @ORM\Entity()
 */
class MenuCollation
{
    /**
     * @var Menu
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuCollations", cascade={"persist"})
     */
    private $menu;

    /**
     * @var Collation
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Collation", inversedBy="menuCollations", cascade={"persist"})
     */
    private $collation;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $position;

    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * @param Menu $menu
     */
    public function setMenu($menu)
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
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Collation $collation
     */
    public function setCollation(Collation $collation)
    {
        $this->collation = $collation;
    }

    /**
     * @return Collation
     */
    public function getCollation()
    {
        return $this->collation;
    }
}

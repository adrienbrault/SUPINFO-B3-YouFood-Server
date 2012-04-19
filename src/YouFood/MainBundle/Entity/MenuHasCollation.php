<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuHasCollation
 *
 * @ORM\Entity()
 * @ORM\Table(name="menu_has_collation")
 */
class MenuHasCollation
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
     * @var Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuHasCollations", cascade={"persist"})
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $menu;

    /**
     * @var Collation
     *
     * @ORM\ManyToOne(targetEntity="Collation", inversedBy="menuHasCollations")
     * @ORM\JoinColumn(name="collation_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $collation;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

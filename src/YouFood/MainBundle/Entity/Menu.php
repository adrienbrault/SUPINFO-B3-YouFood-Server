<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Menu
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationRepository")
 * @ORM\Table(name="menus")
 */
class Menu extends Product
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MenuHasCollation", mappedBy="menu", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     *
     * @Assert\NotBlank()
     */
    private $menuHasCollations;

    /**
     * @var array Array used by serialization
     */
    private $collations;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->menuHasCollations = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getMenuHasCollations()
    {
        return $this->menuHasCollations;
    }

    /**
     * @param ArrayCollection $menuHasCollations
     */
    public function setMenuHasCollations($menuHasCollations)
    {
        foreach ($menuHasCollations as $menuHasCollation) {
            $menuHasCollation->setMenu($this);
        }

        $this->menuHasCollations = $menuHasCollations;
    }

    /**
     * @param MenuHasCollation $menuHasCollation
     */
    public function addMenuHasCollations(MenuHasCollation $menuHasCollation)
    {
        $menuHasCollation->setMenu($this);

        $this->menuHasCollations[] = $menuHasCollation;
    }

    /**
     * @param array $collations
     */
    public function setCollations($collations)
    {
        $this->collations = $collations;
    }

    /**
     * @return array
     */
    public function getCollations()
    {
        return $this->collations;
    }

    public function preSerialize()
    {
        $this->collations = array_map(function ($menuHasCollation) {
            return $menuHasCollation->getCollation();
        }, $this->getMenuHasCollations()->getValues());
    }
}

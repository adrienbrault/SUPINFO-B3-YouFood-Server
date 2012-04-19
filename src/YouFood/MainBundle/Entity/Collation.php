<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Application\Sonata\MediaBundle\Entity\Media;

/**
 * Collation
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationRepository")
 * @ORM\Table(name="collations")
 */
class Collation extends Product
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="collations")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $category;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MenuHasCollation", mappedBy="collation", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $menuHasCollations;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->menuHasCollations = new ArrayCollection();
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        // Update inverse side
        if (null !== $this->category) {
            $this->category->getCollations()->removeElement($this);
        }

        if (null !== $category) {
            $category->getCollations()->add($this);
        }

        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Media $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
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
            $menuHasCollation->setCollation($this);
        }

        $this->menuHasCollations = $menuHasCollations;
    }

    /**
     * @param MenuHasCollation $menuHasCollation
     */
    public function addMenuHasCollations(MenuHasCollation $menuHasCollation)
    {
        $menuHasCollation->setCollation($this);

        $this->menuHasCollations[] = $menuHasCollation;
    }
}

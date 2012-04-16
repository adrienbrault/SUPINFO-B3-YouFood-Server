<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Collation
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationRepository")
 */
class Collation extends Product
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="collations")
     */
    private $category;

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        // Update inverse side
        if (null !== $this->category) {
            $this->category->getCollations()->removeElement($this);
        }
        $category->getCollations()->add($this);

        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}

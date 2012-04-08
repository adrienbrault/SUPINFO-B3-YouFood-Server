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
    public function setCategory($category)
    {
        if (null !== $this->category) {
            $this->category->getCollations()->removeElement($this); // Update inverse side
        }

        $this->category = $category;

        $category->getCollations()->add($this); // Update inverse side
    }

    /**
     * @return \YouFood\MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}

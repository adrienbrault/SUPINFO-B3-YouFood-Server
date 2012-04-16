<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Application\Sonata\MediaBundle\Entity\Media;

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
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     */
    private $image;

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
}

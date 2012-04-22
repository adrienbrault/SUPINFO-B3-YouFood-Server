<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Theme
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\ThemeRepository")
 * @ORM\Table(name="themes")
 */
class Theme
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
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Week", mappedBy="theme", cascade={"persist"})
     */
    private $weeks;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="themes", cascade={"persist"})
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->weeks = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getWeeks()
    {
        return $this->weeks;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        $product->getThemes()->add($this); // Update inverse side
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}

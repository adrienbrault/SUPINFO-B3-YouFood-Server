<?php

namespace YouFood\ApiBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

use YouFood\MainBundle\Entity\Product;
use YouFood\MainBundle\Entity\Table;

/**
 * Order
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @Assert\Callback(methods={"hasEnoughProducts"})
 */
class Order
{
    /**
     * @var ArrayCollection
     */
    private $collations;

    /**
     * @var ArrayCollection
     */
    private $menus;

    /**
     * @var Table
     *
     * @Assert\NotBlank()
     */
    private $table;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->collations = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $collations
     */
    public function setCollations($collations)
    {
        $this->collations = $collations;
    }

    /**
     * @return ArrayCollection
     */
    public function getCollations()
    {
        return $this->collations;
    }

    /**
     * @param ArrayCollection $menus
     */
    public function setMenus($menus)
    {
        $this->menus = $menus;
    }

    /**
     * @return ArrayCollection
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * @param Table $table
     */
    public function setTable(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param ExecutionContext $context
     */
    public function hasEnoughProducts(ExecutionContext $context)
    {
        if ($this->getCollations()->count() == 0 && $this->getMenus()->count() == 0) {
            $context->addViolation('You must add at least 1 collation or at least 1 menu.');
        }
    }
}

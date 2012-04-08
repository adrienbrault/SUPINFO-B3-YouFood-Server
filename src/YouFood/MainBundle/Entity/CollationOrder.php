<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CollationOrder
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationOrderRepository")
 */
class CollationOrder extends ProductOrder
{
    /**
     * @var Collation
     *
     * @ORM\ManyToOne(targetEntity="Collation")
     */
    private $collation;

    /**
     * @param Collation $collation
     */
    public function setCollation($collation)
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

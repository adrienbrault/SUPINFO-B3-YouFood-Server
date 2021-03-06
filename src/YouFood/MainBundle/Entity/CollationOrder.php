<?php

namespace YouFood\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CollationOrder
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity(repositoryClass="YouFood\MainBundle\Repository\CollationOrderRepository")
 * @ORM\Table(name="collation_orders")
 */
class CollationOrder extends ProductOrder
{
    /**
     * @var Collation
     *
     * @ORM\ManyToOne(targetEntity="Collation")
     * @ORM\JoinColumn(name="collation_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $collation;

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

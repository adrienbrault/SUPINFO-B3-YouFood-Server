<?php

namespace YouFood\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user_group")
 */
class Group extends BaseGroup
{
    /**
     * @var int $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

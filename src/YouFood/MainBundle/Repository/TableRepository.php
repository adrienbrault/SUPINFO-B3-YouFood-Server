<?php

namespace YouFood\MainBundle\Repository;

use YouFood\Doctrine\ORM\EntityRepository;

use YouFood\UserBundle\Entity\User;

/**
 * TableRepository
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class TableRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function getTablesAssignedTo(User $user)
    {
        $qb = $this->createQueryBuilder($alias = 't');

        $qb ->join('t.zone', 'z');

        $qb ->andWhere($qb->expr()->eq('z.waiter', ':waiter'))
            ->setParameter('waiter', $user);

        return $qb->getQuery()->getResult();
    }
}

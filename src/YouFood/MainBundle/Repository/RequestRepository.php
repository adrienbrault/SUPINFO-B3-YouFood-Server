<?php

namespace YouFood\MainBundle\Repository;

use YouFood\Doctrine\ORM\EntityRepository;

use YouFood\UserBundle\Entity\User;

/**
 * RequestRepository
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class RequestRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function getRequestsAssignedTo(User $user)
    {
        $qb = $this->createQueryBuilder($alias = 'r');

        $qb ->join('r.table', 't')
            ->join('t.zone', 'z');

        $qb ->andWhere($qb->expr()->eq('z.waiter', ':waiter'))
            ->setParameter('waiter', $user);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array     $tables The tables
     * @param \DateTime $date   The date
     *
     * @return array
     */
    public function getNonProcessedRequestsAtTables(array $tables, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('r');

        $qb ->andWhere($qb->expr()->in('r.table', $tables))
            ->andWhere($qb->expr()->gt('r.createdAt', ':date_min'))
            ->andWhere($qb->expr()->lt('r.createdAt', ':date_max'))
            ->andWhere($qb->expr()->eq('r.processed', 0));

        $dateMin = clone $date;
        $dateMin->setTime(0, 0, 0);
        $dateMax = clone $dateMin;
        $dateMax->setTime(23, 59, 59);

        $qb ->setParameter('date_min', $dateMin)
            ->setParameter('date_max', $dateMax);

        return $qb->getQuery()->getResult();
    }
}

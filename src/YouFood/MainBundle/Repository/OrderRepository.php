<?php

namespace YouFood\MainBundle\Repository;

use YouFood\Doctrine\ORM\EntityRepository;

/**
 * OrderRepository
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class OrderRepository extends EntityRepository
{
    /**
     * @param array     $tables The tables
     * @param \DateTime $date   The date
     *
     * @return array
     */
    public function getNonServedOrdersAtTables(array $tables, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('o');

        $qb ->andWhere($qb->expr()->in('o.table', $tables))
            ->andWhere($qb->expr()->gt('o.date', ':date_min'))
            ->andWhere($qb->expr()->lt('o.date', ':date_max'))
            ->andWhere($qb->expr()->eq('o.served', 0));

        $dateMin = clone $date;
        $dateMin->setTime(0, 0, 0);
        $dateMax = clone $dateMin;
        $dateMax->setTime(23, 59, 59);

        $qb ->setParameter('date_min', $dateMin)
            ->setParameter('date_max', $dateMax);

        return $qb->getQuery()->getResult();
    }
}

<?php

namespace YouFood\Doctrine\ORM;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * EntityRepository
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class EntityRepository extends DoctrineEntityRepository
{
    /**
     * @param array $ids An array of ids
     *
     * @return array
     */
    public function getByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->andWhere($qb->expr()->in('e.id', $ids));

        return $qb->getQuery()->getResult();
    }
}

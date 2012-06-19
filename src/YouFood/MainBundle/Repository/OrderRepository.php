<?php

namespace YouFood\MainBundle\Repository;

use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

use YouFood\Doctrine\ORM\EntityRepository;
use YouFood\MainBundle\Entity\Order;
use YouFood\MainBundle\Entity\Restaurant;
use YouFood\MainBundle\Entity\Category;

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

    /**
     * @param PaymentInstruction $paymentInstruction
     *
     * @return Order
     */
    public function findOneByPaymentInstruction(PaymentInstruction $paymentInstruction)
    {
        return $this->findOneBy(array(
            'paymentInstruction' => $paymentInstruction,
        ));
    }

    public function selectPaidOrdersCountByPeriodQB(\DateTime $minDate = null, \DateTime $maxDate = null)
    {
        $qb = $this->createQueryBuilder('o');

        $qb->andWhere($qb->expr()->eq('o.paid', '1'));

        if ($minDate) {
            $qb ->andWhere($qb->expr()->gte('o.date', ':min_date'))
                ->setParameter('min_date', $minDate);
        }

        if ($maxDate) {
            $qb ->andWhere($qb->expr()->lte('o.date', ':max_date'))
                ->setParameter('max_date', $maxDate);
        }

        $qb->select($qb->expr()->count('o'));

        return $qb;
    }

    public function getPaidOrdersCountByRestaurantAndPeriod(Restaurant $restaurant, \DateTime $minDate = null, \DateTime $maxDate = null)
    {
        $qb = $this->selectPaidOrdersCountByPeriodQB($minDate, $maxDate);

        $qb->join('o.table', 't');
        $qb->join('t.zone', 'z');

        $qb ->andWhere($qb->expr()->eq('z.restaurant', ':restaurant'))
            ->setParameter('restaurant', $restaurant);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getPaidOrdersCountByCategoryAndPeriod(Category $category, \DateTime $minDate = null, \DateTime $maxDate = null)
    {
        $qb = $this->selectPaidOrdersCountByPeriodQB($minDate, $maxDate);

        $qb->join('o.productOrders', 'po');

        $qb->andWhere('po IN (SELECT co FROM YouFoodMainBundle:CollationOrder AS co JOIN co.collation AS collation WHERE collation.category = :category)');

        $qb->setParameter('category', $category);

        return $qb->getQuery()->getSingleScalarResult();
    }
}

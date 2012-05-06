<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\View;

use YouFood\MainBundle\Repository\WeekRepository;

/**
 * WeekController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class WeekController extends Controller
{
    /**
     * @return View
     */
    public function getWeeksAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'week_list'));

        return $view;
    }

    /**
     * @param integer $id
     *
     * @return View
     */
    public function getWeekAction($id)
    {
        $week = $this->getRepository()->find($id);

        if (null === $week) {
            throw $this->createNotFoundException('Week not found.');
        }

        $view = View::create($week);
        $view->setSerializerGroups(array('id', 'week_detail'));

        return $view;
    }

    /**
     * @return WeekRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine')->getEntityManager()->getRepository('YouFoodMainBundle:Week');
    }
}

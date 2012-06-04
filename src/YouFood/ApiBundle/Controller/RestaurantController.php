<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\RestaurantRepository;

/**
 * RestaurantController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class RestaurantController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of restaurants")
     */
    public function getRestaurantsAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'restaurant_full'));

        return $view;
    }

    /**
     * @param string $id The restaurant id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a restaurant")
     * @Route(requirements={"id"="\d+"})
     */
    public function getRestaurantAction($id)
    {
        $restaurant = $this->getRepository()->find($id);

        if (null === $restaurant) {
            throw $this->createNotFoundException('Restaurant not found.');
        }

        $view = View::create($restaurant);
        $view->setSerializerGroups(array('id', 'restaurant_full'));

        return $view;
    }

    /**
     * @return RestaurantRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Restaurant');
    }
}

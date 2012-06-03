<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\MenuRepository;

/**
 * MenuController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class MenuController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of menus")
     */
    public function getMenusAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'product_full', 'menu_full'));

        return $view;
    }

    /**
     * @param string $id The menu id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a menu")
     * @Route(requirements={"id"="\d+"})
     */
    public function getMenuAction($id)
    {
        $menu = $this->getRepository()->find($id);

        if (null === $menu) {
            throw $this->createNotFoundException('Menu not found.');
        }

        $view = View::create($menu);
        $view->setSerializerGroups(array('id', 'product_full', 'menu_full'));

        return $view;
    }

    /**
     * @return MenuRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Menu');
    }
}

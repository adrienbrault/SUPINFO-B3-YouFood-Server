<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\View\View;

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
     */
    public function getMenusAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'product_list', 'menu_list'));

        return $view;
    }

    /**
     * @param string $id
     *
     * @return View
     */
    public function getMenuAction($id)
    {
        $menu = $this->getRepository()->find($id);

        if (null === $menu) {
            throw $this->createNotFoundException('Menu not found.');
        }

        $view = View::create($menu);
        $view->setSerializerGroups(array('id', 'product_detail', 'menu_detail'));

        return $view;
    }

    /**
     * @return MenuRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine')->getEntityManager()->getRepository('YouFoodMainBundle:Menu');
    }
}

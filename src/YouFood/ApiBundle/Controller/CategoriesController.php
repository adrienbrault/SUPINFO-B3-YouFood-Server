<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\CategoryRepository;

/**
 * CategoriesController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class CategoriesController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of categories")
     */
    public function getCategoriesAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'category_full'));

        return $view;
    }

    /**
     * @param integer $id The category id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a category")
     * @Route(requirements={"id"="\d+"})
     */
    public function getCategoryAction($id)
    {
        $category = $this->getRepository()->find($id);

        if (null === $category) {
            throw $this->createNotFoundException('Category not found.');
        }

        $view = View::create($category);
        $view->setSerializerGroups(array('id', 'category_full'));

        return $view;
    }

    /**
     * @return CategoryRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Category');
    }
}

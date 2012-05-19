<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\ThemeRepository;

/**
 * ThemeController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class ThemeController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of themes")
     */
    public function getThemesAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'theme_full'));

        return $view;
    }

    /**
     * @param integer $id The theme id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a theme")
     * @Route(requirements={"id"="\d+"})
     */
    public function getThemeAction($id)
    {
        $theme = $this->getRepository()->find($id);

        if (null === $theme) {
            throw $this->createNotFoundException('Theme not found.');
        }

        $view = View::create($theme);
        $view->setSerializerGroups(array('id', 'theme_full'));

        return $view;
    }

    /**
     * @return ThemeRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine')->getEntityManager()->getRepository('YouFoodMainBundle:Theme');
    }
}

<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\ZoneRepository;

/**
 * ZoneController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class ZoneController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of zones")
     */
    public function getZonesAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'zone_full'));

        return $view;
    }

    /**
     * @param string $id The zone id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a zone")
     * @Route(requirements={"id"="\d+"})
     */
    public function getZoneAction($id)
    {
        $zone = $this->getRepository()->find($id);

        if (null === $zone) {
            throw $this->createNotFoundException('Zone not found.');
        }

        $view = View::create($zone);
        $view->setSerializerGroups(array('id', 'zone_full'));

        return $view;
    }

    /**
     * @return ZoneRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Zone');
    }
}

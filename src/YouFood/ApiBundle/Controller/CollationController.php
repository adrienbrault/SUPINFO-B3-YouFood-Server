<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\CollationRepository;

/**
 * CollationController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class CollationController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of collations")
     */
    public function getCollationsAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'product_full', 'collation_full'));

        return $view;
    }

    /**
     * @param integer $id The collation id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collation")
     * @Route(requirements={"id"="\d+"})
     */
    public function getCollationAction($id)
    {
        $collation = $this->getRepository()->find($id);

        if (null === $collation) {
            throw $this->createNotFoundException('Collation not found.');
        }

        $view = View::create($collation);
        $view->setSerializerGroups(array('id', 'product_full', 'collation_full', 'media_full'));

        return $view;
    }

    /**
     * @return CollationRepository
     */
    protected function getRepository()
    {
        return $this->get('doctrine')->getEntityManager()->getRepository('YouFoodMainBundle:Collation');
    }
}

<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\TableRepository;
use YouFood\MainBundle\Entity\Request;

/**
 * TablesController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class TablesController extends Controller
{
    /**
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a collection of tables")
     */
    public function getTablesAction()
    {
        $view = View::create($this->getRepository()->findAll());
        $view->setSerializerGroups(array('id', 'table_full'));

        return $view;
    }

    /**
     * @param string $id The table id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a table")
     * @Route(requirements={"id"="\d+"})
     */
    public function getTableAction($id)
    {
        $table = $this->getRepository()->find($id);

        if (null === $table) {
            throw $this->createNotFoundException('Table not found.');
        }

        $view = View::create($table);
        $view->setSerializerGroups(array('id', 'table_full'));

        return $view;
    }

    /**
     * @param int $id The table id
     *
     * @return View
     *
     * @ApiDoc(description="Request a waiter at a table")
     * @Route(requirements={"id"="\d+"})
     */
    public function patchTableRequestWaiterAction($id)
    {
        $table = $this->getRepository()->find($id);

        if (null === $table) {
            throw $this->createNotFoundException('Table not found.');
        }

        $request = new Request('waiter');
        $request->setTable($table);
        $em = $this->getDoctrine()->getEntityManagerForClass(get_class($request));
        $em->persist($request);
        $em->flush();

        return View::create('', 202);
    }

    /**
     * @return TableRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Table');
    }
}

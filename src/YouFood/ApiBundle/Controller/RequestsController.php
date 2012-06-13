<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\RequestRepository;
use YouFood\MainBundle\Repository\TableRepository;
use YouFood\MainBundle\Entity\Request;

/**
 * RequestsController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class RequestsController extends Controller
{
    /**
     * @param string $tables
     *
     * @return View
     *
     * @QueryParam(name="tables", requirements="(\d+,?)+", description="Tables")
     * @ApiDoc(resource=true, description="Get a collection of requests")
     */
    public function getRequestsAction($tables)
    {
        $tableIds = explode(',', $tables);

        $tables = $this->getTableRepository()->getByIds($tableIds);

        if (count($tables) != count($tableIds)) {
            $foundTablesIds = array_map(function ($table) {
                return $table->getId();
            }, $tables);
            $tablesIdsNotFound = array_diff($tableIds, $foundTablesIds);

            return View::create(array(
                'tablesNotFound' => $tablesIdsNotFound,
            ), 404);
        } elseif (count($tables) == 0) {
            return View::create(array());
        }

        $requestDate = new \DateTime(sprintf('@%d', $this->getRequest()->server->get('REQUEST_TIME')));
        $requests = $this->getRepository()->getNonProcessedRequestsAtTables($tables, $requestDate);

        $view = View::create($requests);
        $view->setSerializerGroups(array('id', 'request_full'));

        return $view;
    }

    /**
     * @param int $id The request id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get a request")
     * @Route(requirements={"id"="\d+"})
     */
    public function getRequestAction($id)
    {
        $request = $this->getRepository()->find($id);

        if (null === $request) {
            throw $this->createNotFoundException('Request not found.');
        }

        $view = View::create($request);
        $view->setSerializerGroups(array('id', 'request_full'));

        return $view;
    }

    /**
     * @param int $id
     *
     * @return View
     *
     * @ApiDoc(resource=false, description="Mark a request as processed.")
     * @Route(requirements={"id"="\d+"})
     */
    public function postRequestMarkAsProcessedAction($id)
    {
        $request = $this->getRepository()->find($id); /** @var $request Request */

        if (null === $request) {
            throw $this->createNotFoundException('Request not found.');
        }

        $request->setProcessed(true);
        $this->getDoctrine()->getManager()->flush();

        return View::create(array(), 202);
    }

    /**
     * @return RequestRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Request');
    }

    /**
     * @return TableRepository
     */
    protected function getTableRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Table');
    }
}

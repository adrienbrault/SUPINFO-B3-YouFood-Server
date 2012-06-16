<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\MainBundle\Repository\OrderRepository;
use YouFood\MainBundle\Repository\TableRepository;
use YouFood\MainBundle\Entity\Order;

/**
 * OrdersController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class OrdersController extends Controller
{
    /**
     * @param string $tables
     *
     * @return View
     *
     * @QueryParam(name="tables", requirements="(\d+,?)+", description="Tables")
     * @ApiDoc(resource=true, description="Get a collection of orders")
     */
    public function getOrdersAction($tables)
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
        $orders = $this->getRepository()->getNonServedOrdersAtTables($tables, $requestDate);

        $view = View::create($orders);
        $view->setSerializerGroups(array(
            'id',
            'order_full',
            'product_order_full',
            'collation_order_full',
            'menu_order_full',
        ));

        return $view;
    }

    /**
     * @param int $id The order id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get an order")
     * @Route(requirements={"id"="\d+"})
     */
    public function getOrderAction($id)
    {
        $order = $this->getRepository()->find($id);

        if (null === $order) {
            throw $this->createNotFoundException('Order not found.');
        }

        $view = View::create($order);
        $view->setSerializerGroups(array(
            'id',
            'order_full',
            'product_order_full',
            'collation_order_full',
            'menu_order_full',
        ));

        return $view;
    }

    /**
     * @param int $id
     *
     * @return View
     *
     * @ApiDoc(resource=false, description="Set an order as served.")
     * @Route(requirements={"id"="\d+"})
     */
    public function postOrderMarkAsServedAction($id)
    {
        $order = $this->getRepository()->find($id); /** @var $order Order */

        if (null === $order) {
            throw $this->createNotFoundException('Order not found.');
        }

        $order->setServed(true);
        $this->getDoctrine()->getManager()->flush();

        return View::create(array(), 202);
    }

    /**
     * @return OrderRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Order');
    }

    /**
     * @return TableRepository
     */
    protected function getTableRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Table');
    }
}

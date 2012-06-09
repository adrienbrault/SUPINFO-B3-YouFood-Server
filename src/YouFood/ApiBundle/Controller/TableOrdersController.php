<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\ApiBundle\Model\Order as OrderModel;
use YouFood\ApiBundle\Form\OrderType as OrderModelType;
use YouFood\ApiBundle\Factory\OrderFactory;
use YouFood\MainBundle\Entity\Order;
use YouFood\Doctrine\ORM\EntityRepository;
use YouFood\MainBundle\Repository\OrderRepository;

/**
 * TableOrdersController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class TableOrdersController extends Controller
{
    /**
     * @param int $table_id The table id
     * @param int $id       The order id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get an order")
     * @Route(requirements={"table_id"="\d+", "id"="\d+"})
     */
    public function getOrderAction($table_id, $id)
    {
        $table = $this->getRepository('Table')->find($table_id);
        $order = $this->getRepository()->find($id);

        if (null === $table || null === $order) {
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
     * @param Request $request  The request
     * @param int     $table_id The table id
     *
     * @ApiDoc(formType="YouFood\ApiBundle\Form\OrderType", description="Create an order")
     * @Route(requirements={"table_id"="\d+"})
     */
    public function postOrdersAction(Request $request, $table_id)
    {
        $table = $this->getRepository('Table')->find($table_id);

        if (null === $table) {
            throw $this->createNotFoundException('Table not found.');
        }

        $orderModel = new OrderModel();
        $orderModel->setTable($table);
        $form = $this->createForm(new OrderModelType(), $orderModel);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $orderFactory = new OrderFactory();
            $order = $orderFactory->create($orderModel);

            $em = $this->getDoctrine()->getEntityManagerForClass(get_class($order));
            $em->persist($order);
            $em->flush();

            $view = RouteRedirectView::create('youfood_api_rest_get_table_order', array(
                'table_id' => $order->getTable()->getId(),
                'id' => $order->getId(),
            ));
        } else {
            $view = View::create($form);
        }

        return $view;
    }

    /**
     * @param string $class The class name without namespace
     *
     * @return EntityRepository
     */
    protected function getRepository($class = 'Order')
    {
        return $this->getDoctrine()->getRepository(sprintf('YouFoodMainBundle:%s', $class));
    }
}

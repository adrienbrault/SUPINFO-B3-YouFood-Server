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
use YouFood\MainBundle\Repository\OrderRepository;

/**
 * OrderController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class OrderController extends Controller
{
    /**
     * @param string $id The order id
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
     * @param Request $request
     *
     * @ApiDoc(formType="YouFood\ApiBundle\Form\OrderType", description="Create an order")
     */
    public function postOrdersAction(Request $request)
    {
        $orderModel = new OrderModel();
        $form = $this->createForm(new OrderModelType(), $orderModel);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $orderFactory = new OrderFactory();
            $order = $orderFactory->create($orderModel);

            $em = $this->getDoctrine()->getEntityManagerForClass(get_class($order));
            $em->persist($order);
            $em->flush();

            $view = RouteRedirectView::create('youfood_api_rest_get_order', array('id' => $order->getId()));
        } else {
            $view = View::create($form);
        }

        return $view;
    }

    /**
     * @return OrderRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodMainBundle:Order');
    }
}

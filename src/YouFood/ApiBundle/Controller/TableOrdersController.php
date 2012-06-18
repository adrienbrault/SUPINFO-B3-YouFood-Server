<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\Rest\Util\Codes;

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

            $view = RouteRedirectView::create('youfood_api_rest_get_order', array(
                'id' => $order->getId(),
            ), Codes::HTTP_CREATED, array(
                'YouFood-PaymentUrl' => $this->generateUrl('youfood_payment_payment_details', array('id' => $order->getId()), true),
            ));
        } else {
            $view = View::create($form, 400);
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

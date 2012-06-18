<?php

namespace YouFood\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\Payment\CoreBundle\Entity\Payment;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;

use YouFood\MainBundle\Entity\Order;

/**
 * PaymentController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @Route("/payments")
 */
class PaymentController extends Controller
{
    /**
     * @Route("/{id}/details")
     * @Template()
     */
    public function detailsAction(Request $request, $id)
    {
        $order = $this->getOrder($id);

        if ($order->isPaid()) {
            return $this->redirect($this->generateUrl('youfood_payment_payment_complete', array(
                'id' => $order->getId(),
            )));
        }

        $form = $this->get('form.factory')->create('jms_choose_payment_method', null, array(
            'currency' => 'EUR',
            'amount'   => $order->getAmount(),
            'predefined_data' => array(
                'paypal_express_checkout' => array(
                    'return_url' => $this->generateUrl('youfood_payment_payment_complete', array(
                        'id' => $order->getId(),
                    ), true),
                    'cancel_url' => $this->generateUrl('youfood_payment_payment_cancel', array(
                        'id' => $order->getId(),
                    ), true),
                ),
            ),
        ));

        if ($request->isMethod('POST')) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->get('payment.plugin_controller')->createPaymentInstruction($instruction = $form->getData());

                $order->setPaymentInstruction($instruction);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($order);
                $manager->flush();

                return $this->redirect($this->generateUrl('youfood_payment_payment_complete', array(
                    'id' => $order->getId(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
            'order' => $order,
        );
    }

    /**
     * @Route("/{id}/complete")
     * @Template
     */
    public function completeAction($id)
    {
        $order = $this->getOrder($id);

        $instruction = $order->getPaymentInstruction();
        if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
            $payment = $this->get('payment.plugin_controller')->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
        } else {
            $payment = $pendingTransaction->getPayment();
        }

        $result = $this->get('payment.plugin_controller')->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
        if (Result::STATUS_PENDING === $result->getStatus()) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }

                throw $ex;
            }
        } else if (Result::STATUS_SUCCESS !== $result->getStatus()) {
            throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
        }

        if (!$order->isPaid()) {
            return $this->redirect($this->generateUrl('youfood_payment_payment_details', array(
                'id' => $order->getId(),
            )));
        }

        return array(
            'order' => $order,
        );
    }

    /**
     * @Route("/{id}/cancel")
     * @Template
     */
    public function cancelAction($id)
    {
        $order = $this->getOrder($id);

        return array(
            'order' => $order,
        );
    }

    /**
     * @param int $id
     *
     * @return Order
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getOrder($id)
    {
        $order = $this->getDoctrine()->getRepository('YouFoodMainBundle:Order')->find($id);

        if (null === $order) {
            throw $this->createNotFoundException('Order not found.');
        }

        return $order;
    }
}

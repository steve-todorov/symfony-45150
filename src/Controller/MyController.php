<?php

namespace App\Controller;

use App\Form\InvoiceFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class MyController extends AbstractController
{

    /**
     * List payments
     *
     * @Route(methods={"GET"}, path="/", name="finance_payments")
     */

    public function indexPayment(): Response
    {
        return new Response("Listing payments (just a placeholder)", 200, []);
    }

    /**
     * Create a payment.
     *
     * @Route(methods={"GET", "POST"}, path="/create", name="finance_payments_create", defaults={"payment": null})
     * @Route(methods={"GET", "POST"}, path="/example", name="finance_payments_example", defaults={"payment": null})
     *
     * @Template("manage.html.twig")
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function managePayment(Request $request)
    {

        $form = $this->createNewPaymentsForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('finance_payments'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @return FormInterface
     */
    private function createNewPaymentsForm(): FormInterface
    {
        $form = $this->createForm(
            InvoiceFormType::class,
            null,
            array(
                'action' => $this->generateUrl('finance_payments_create'),
                'method' => 'POST'
            )
        );

        return $form;
    }

}
<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyControllerTest extends WebTestCase
{


    public function testCreateAndShow()
    {

        $invoicePayments = [
            ['amount' => 101, 'note' => 'Node 1'],
            ['amount' => 102, 'note' => 'Note 2'],
            ['amount' => 103, 'note' => 'Note 3'],
        ];

        $this->createPaymentViaForm($invoicePayments);

        $crawler = self::createClient()->request('GET', '/');
        $tableRows = $crawler->filter('#paymentRecords tr');

        static::assertGreaterThanOrEqual(count($invoicePayments), $tableRows->count());
    }

    private function createPaymentViaForm(array $invoices)
    {
        /**
         * @var KernelBrowser
         */
        $client = self::createClient();

        $crawler = $client->request('GET', '/create');

        $form = $crawler->filter('form')->form();

        $values = $form->getPhpValues();

        $values['invoice_form']['client'] = 123456;
        $values['invoice_form']['transactionNumber'] = "ABCD12346";

        $i = 0;
        foreach ($invoices as $invoice) {
            $values["invoice_form"]['payments'][$i]['amount'] = $invoice['amount'];
            $values["invoice_form"]['payments'][$i]['note'] = $invoice['note'];
            $i++;
        }

        // submit
        $client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        // assert post was successful and redirects to the respectful route.
        $this->assertTrue($client->getResponse()->isRedirect('/'));
    }

}

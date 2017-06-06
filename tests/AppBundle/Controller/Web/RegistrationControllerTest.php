<?php

namespace AppBundle\Tests\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        // Assert a specific 200 status code
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );

        // Assert that there are exactly 6 inputs tags on the page  
        $this->assertCount(7, $crawler->filter('input'));

        $buttonCrawlerNode = $crawler->selectButton('Register!');

        $form = $buttonCrawlerNode->form();

        // TODO: update test with success user create process
        $client->submit($form);

        // Assert a specific 200 status code
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );
    }

}

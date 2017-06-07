<?php

namespace Tests\AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testGETRegisterPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        // Assert a specific 200 status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert that there are exactly 6 inputs tags on the page  
        $this->assertCount(7, $crawler->filter('input'));
    }

    public function testPOSTRegisterPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');

        $buttonCrawlerNode = $crawler->selectButton('Register!');

        $data = [
            'name' => '',
            'username' => '',
            'email' => '',
            'password' => '',
        ];

        $form = $buttonCrawlerNode->form();

        // TODO: update test with success user create process
        $client->submit($form, $data);

        // Assert a specific 200 status code
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }    
}

<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends webTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
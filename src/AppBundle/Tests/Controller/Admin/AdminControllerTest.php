<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testMainPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administrator');

        $this->assertContains('Cherkassy Dande Portal', $crawler->filter('.baner h2')->text());
    }
}

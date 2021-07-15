<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HitControllerTest extends WebTestCase
{
    public function testMethod()
    {
        $client = static::createClient();
        $client->request('GET', 'api/hit');

        self::assertEquals(405, $client->getResponse()->getStatusCode());
    }
}
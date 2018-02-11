<?php

namespace App\Tests;

class DefaultTest extends DoctrineTestCase
{
    public function testDemoRouteIsJSONAware()
    {
        $client = static::createClient();
        $client->request('GET', '/api/users', [], [], [
            'HTTP_Accept' => 'application/json',
        ]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
    }

    public function testDemoRouteIsXMLAware()
    {
        $client = static::createClient();
        $client->request('GET', '/api/users', [], [], ['HTTP_Accept' => 'application/xml']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/xml'));
    }
}

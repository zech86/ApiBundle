<?php

namespace Zechim\ApiBundle\Tests\EventListener;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RequestDecoderListenerTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testShouldDecodeRequest()
    {
        $request = 'my request';
        $encoded = static::$kernel->getContainer()->get('zechim_api.encrypt_decrypt')->encode($request);

        $client = self::createClient();
        $client->request('GET', '/decode-request', [], [], [], $encoded);

        $this->assertEquals(json_encode(['message' => $request]), $client->getResponse()->getContent());
    }

    public function testShouldNotDecodeRequest()
    {
        $request = 'my request';
        $encoded = static::$kernel->getContainer()->get('zechim_api.encrypt_decrypt')->encode($request);

        $client = self::createClient();
        $client->request('GET', '/do-not-decode-request', [], [], [], $encoded);

        $this->assertEquals(json_encode(['message' => $encoded]), $client->getResponse()->getContent());
    }
}
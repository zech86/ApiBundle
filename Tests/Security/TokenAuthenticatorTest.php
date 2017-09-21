<?php

namespace Zechim\ApiBundle\Tests\EventListener;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenAuthenticatorTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function testShouldAuthenticate()
    {
        $encoded = static::$kernel->getContainer()->get('zechim_api.encrypt_decrypt')->encode(json_encode(['username' => 'my_user_name']));

        # http://symfony.com/doc/current/testing.html
        # https://stackoverflow.com/questions/11549672/symfony-functional-test-custom-headers-not-passing-through
        # SF convert HTTP_MY_CUSTOM_HEADER to my-custom-reader
        # app-token is zechim_api.builder.credential_name
        $server = ['HTTP_APP_TOKEN' => $encoded];

        $client = self::createClient();
        $client->request('GET', '/authenticated/require-authentication', [], [], $server);

        $this->assertEquals('authenticated', $client->getResponse()->getContent());
    }

    public function testShouldNotAuthenticate()
    {
        $encoded = static::$kernel->getContainer()->get('zechim_api.encrypt_decrypt')->encode(json_encode(['username' => 'invalid_user_name']));

        # http://symfony.com/doc/current/testing.html
        # https://stackoverflow.com/questions/11549672/symfony-functional-test-custom-headers-not-passing-through
        # SF convert HTTP_MY_CUSTOM_HEADER to my-custom-reader
        # app-token is zechim_api.builder.credential_name
        $server = ['HTTP_APP_TOKEN' => $encoded];

        $client = self::createClient();
        $client->request('GET', '/authenticated/require-authentication', [], [], $server);

        $this->assertEquals(json_encode(['message' => 'Username could not be found.']), $client->getResponse()->getContent());
    }
}
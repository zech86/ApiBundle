<?php

namespace Zechim\ApiBundle\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use SimpleEncryptedText\OpenSSL;
use Symfony\Component\HttpFoundation\Request;
use Zechim\ApiBundle\Security\Credential\HeaderCredential;

class HeaderCredentialTest extends TestCase
{
    public function testShouldReturnCredential()
    {
        $encoder = new OpenSSL('my-key');

        $credentialName = 'credential_name';
        $encoded = $encoder->encode(json_encode(['username' => 'my_user_name']));

        $request = new Request();
        $request->headers->set($credentialName, $encoded);

        $headerCredential = new HeaderCredential($credentialName, $encoder);

        $credential = $headerCredential->getCredentialFromRequest($request);

        $this->assertEquals('my_user_name', $credential->getUsername());
    }
}
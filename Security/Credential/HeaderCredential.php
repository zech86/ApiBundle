<?php

namespace Zechim\ApiBundle\Security\Credential;

use SimpleEncryptedText\EncryptDecryptInterface;
use Symfony\Component\HttpFoundation\Request;

final class HeaderCredential implements CredentialFetcherInterface
{
    /**
     * @var string
     */
    private $credentialName;

    /**
     * @var EncryptDecryptInterface
     */
    private $decoder;

    public function __construct($credentialName, EncryptDecryptInterface $decoder)
    {
        $this->credentialName = $credentialName;
        $this->decoder = $decoder;
    }

    /**
     * @param Request $request
     * @return CredentialInterface
     */
    public function getCredentialFromRequest(Request $request)
    {
        $credential = $this->decoder->decode($request->headers->get($this->credentialName));
        $credential = json_decode($credential, true);

        return new Credential($credential);
    }
}
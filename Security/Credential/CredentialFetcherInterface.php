<?php

namespace Zechim\ApiBundle\Security\Credential;

use Symfony\Component\HttpFoundation\Request;

interface CredentialFetcherInterface
{
    /**
     * @param Request $request
     * @return CredentialInterface
     */
    function getCredentialFromRequest(Request $request);
}
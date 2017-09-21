<?php

namespace Zechim\ApiBundle\Security\Credential;

use Symfony\Component\HttpFoundation\Request;

interface CredentialInterface
{
    /**
     * @return string
     */
    function getUsername();
}
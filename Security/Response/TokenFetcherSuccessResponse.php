<?php

namespace Zechim\ApiBundle\Security\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class TokenFetcherSuccessResponse extends JsonResponse
{
    public function __construct($token)
    {
        parent::__construct(['token' => $token]);
    }
}
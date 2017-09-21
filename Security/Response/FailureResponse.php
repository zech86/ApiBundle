<?php

namespace Zechim\ApiBundle\Security\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

final class FailureResponse extends JsonResponse
{
    public function __construct($message = 'Bad credentials', $status = JsonResponse::HTTP_UNAUTHORIZED)
    {
        parent::__construct(['message' => $message], $status);
    }
}
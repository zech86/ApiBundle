<?php

namespace Zechim\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zechim\ApiBundle\Annotation\DecodeRequest;

class TestController extends Controller
{
    /**
     * @DecodeRequest
     * @param Request $request
     * @return JsonResponse
     */
    public function decodeRequestAction(Request $request)
    {
        return new JsonResponse(['message' => $request->get('decoded_content')]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function withoutDecodeRequestAction(Request $request)
    {
        return new JsonResponse(['message' => $request->getContent()]);
    }

    /**
     * @return Response
     */
    public function requireAuthenticationAction()
    {
        return new Response('authenticated');
    }
}
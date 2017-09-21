<?php

namespace Zechim\ApiBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Zechim\ApiBundle\Security\Credential\CredentialFetcherInterface;
use Zechim\ApiBundle\Security\Credential\CredentialInterface;

final class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var CredentialFetcherInterface
     */
    private $credentialsFetcher;

    public function __construct(CredentialFetcherInterface $credentialFetcher)
    {
        $this->credentialFetcher = $credentialFetcher;
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser(). Returning null will cause this authenticator
     * to be skipped.
     */
    public function getCredentials(Request $request)
    {
        return $this->credentialFetcher->getCredentialFromRequest($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var $credentials CredentialInterface */
        if (false === $credentials instanceof CredentialInterface) {
            return null;
        }

        // if a User object, checkCredentials() is called
        return $userProvider->loadUserByUsername($credentials->getUsername());
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        /** @var $credentials CredentialInterface */
        if (false === $credentials instanceof CredentialInterface) {
            return false;
        }

        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
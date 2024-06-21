<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class CustomAuthenticator extends JWTAuthenticator
{

    public function supports(Request $request): bool
    {
        return $request->cookies->has('jwt_token');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $response = new JsonResponse(['message' =>'Authentication required'], Response::HTTP_UNAUTHORIZED);
        $response->headers->clearCookie('jwt_token');

        return $response;
    }
}

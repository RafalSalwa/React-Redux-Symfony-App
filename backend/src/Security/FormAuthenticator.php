<?php

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\CryptonService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class FormAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly UserPasswordHasherInterface $passwordEncoder,
        private readonly UserService $userService,
        private readonly CryptonService $cryptonService,
    ) {
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate('api_users_login', $request->query->all());
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        if (false === $request->request->has('email') || false === $request->request->has('password')) {
            throw new InvalidArgumentException('Missing authentication parameters in request.');
        }
        $user = $this->checkCredentials($request->request->get('email'), $request->request->get('password'));

        return new SelfValidatingPassport(
            userBadge: new UserBadge($user->getUserIdentifier()),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $jwt = $this->jwtManager->create($token->getUser());
        $response = new JsonResponse(['jwt_token' => $jwt]);
        $response->headers->setCookie(
            new Cookie(
                name: 'jwt_token',
                value: $jwt,
                expire: strtotime('+24 hour'),
                path: '/',
                httpOnly: false,
            )
        );

        return $response;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
    }

    private function checkCredentials(string $email, string $password): UserInterface
    {
        $user = $this->userService->findOne($this->cryptonService->encrypt($email));
        if (null === $user) {
            throw new AuthenticationException("User with such credentials does not exists");
        }

        assert($user instanceof PasswordAuthenticatedUserInterface);
        if (false === $this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new AuthenticationException("Wrong password");
        }

        return $user;
    }
}

<?php

namespace App\Security;

use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method UserInterface loadUserByIdentifierAndPayload(string $identifier, array $payload)
 */
final class UserProvider implements UserProviderInterface, PayloadAwareUserProviderInterface
{

    public function __construct(private readonly UserService $userService)
    {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, UserInterface::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->userService->findOne($identifier);
    }

    public function loadUserByUsernameAndPayload(string $username, array $payload)
    {
    }

    public function loadUserByUsername(string $username)
    {
        return $this->userService->findOne($username);
    }
}

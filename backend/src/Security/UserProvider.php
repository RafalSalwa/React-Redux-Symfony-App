<?php

declare(strict_types=1);

namespace App\Security;

use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function is_subclass_of;

/** @method UserInterface loadUserByIdentifierAndPayload(string $identifier, array $payload) */
final readonly class UserProvider implements UserProviderInterface, PayloadAwareUserProviderInterface
{
    public function __construct(private UserService $userService)
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

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        return $this->userService->findOne($identifier);
    }

    public function loadUserByUsernameAndPayload(string $username, array $payload): void
    {
    }

    public function loadUserByUsername(string $username): ?UserInterface
    {
        return $this->userService->findOne($username);
    }
}

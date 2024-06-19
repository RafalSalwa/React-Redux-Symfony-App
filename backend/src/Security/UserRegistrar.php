<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Exception\AuthenticationException;
use App\Exception\Contracts\UserRegistrarInterface;
use App\Repository\UserRepository;
use App\Security\Exception\ValidationException;
use App\Service\CryptonService;
use App\Validator\UserValidator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function assert;
use function is_array;

final readonly class UserRegistrar implements UserRegistrarInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserValidator $validator,
        private UserRepository $userRepository,
        private CryptonService $cryptonService,
    ) {
    }

    /** @throws ValidationException When request payload does not meet minimum requirements */
    public function validate(UserInterface $user): void
    {
        $errors = $this->validator->validate($user);
        if (is_array($errors)) {
            $validationException = new ValidationException(
                message: 'Request contains data, that could not be processed',
            );
            $validationException->withErrors($errors);

            throw $validationException;
        }
    }

    public function register(UserInterface $user): void
    {
        assert($user instanceof User);

        $user->setEmail($this->cryptonService->encrypt($user->getEmail()));

        $fullName = $user->getFirstName() . ' ' . $user->getLastName();
        $user->setFullName($this->cryptonService->encrypt($fullName));

        $user->setFirstName($this->cryptonService->encrypt($user->getFirstName()));
        $user->setLastName($this->cryptonService->encrypt($user->getLastName()));

        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
    }

    /** @throws AuthenticationException */
    public function accountExists(string $email): void
    {
        $user = $this->userRepository->getUser($this->cryptonService->encrypt($email));
        if (null !== $user) {
            throw new AuthenticationException('Account with such email already exists');
        }
    }
}

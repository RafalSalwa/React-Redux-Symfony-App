<?php

namespace App\Exception\Contracts;

use App\Entity\User;
use App\Security\Exception\ValidationException;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserRegistrarInterface
{
    /**
     * @throws ValidationException When request payload does not meet minimum requirements
     */
    public function validate(UserInterface $user): void;

    public function register(User $user): void;

    /**
     * @throws AuthenticationExceptionInterface
     */
    public function accountExists(string $email);
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function findOne(string $email): ?UserInterface
    {
        return $this->userRepository->getUser($email);
    }

    public function findActiveUsersCreatedSince(DateTimeInterface $dateTime)
    {
        return $this->userRepository->findActiveUsersCreatedSince($dateTime);
    }

    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }
}
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\CryptonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsController]
#[Route('/api/users', name: 'api_users_', methods: ['GET'])]
class UserController extends AbstractController
{
    #[Route('/me', name: 'me', methods: ['GET'])]
    public function me(UserInterface $user, CryptonService $cryptonService): JsonResponse
    {
        assert($user instanceof User);
        $cryptonService->decryptUser($user);
        return $this->json($user, Response::HTTP_OK);
    }
}

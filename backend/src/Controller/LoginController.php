<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsController]
#[Route('/api/users', name: 'api_users_', methods: ['POST'])]
final class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('users_api_me');
        }

        return $this->json(
            ['error' => 'LoginController::error'],
        );
    }

    #[Route(path: '/logout', name: 'logout', methods: ['POST'])]
    public function logout(): Response
    {
        $jsonResponse = new JsonResponse(['message' => 'Logged out successfully']);
        $jsonResponse->headers->clearCookie('jwt_token');

        return $jsonResponse;
    }
}

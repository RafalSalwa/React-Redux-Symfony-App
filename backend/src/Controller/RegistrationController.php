<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Exception\AuthenticationException;
use App\Exception\Contracts\AuthenticationExceptionInterface;
use App\Exception\Contracts\UserRegistrarInterface;
use App\Exception\UploadedFileException;
use App\Form\UserRegistrationType;
use App\Form\Utils\FormErrorExtractor;
use App\Security\Exception\ValidationException;
use App\Service\FileUploader;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/users', name: 'api_users_', methods: ['POST'])]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserRegistrarInterface $userRegistrar,
        FileUploader $fileUploader,
        UserService $userService,
    ): JsonResponse {

        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        $form->submit($request->request->all(), false);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userRegistrar->validate($user);
                $userRegistrar->accountExists($user->getEmail());
                $userRegistrar->register($user);

                $fileUploader->processRequestFiles($request, $user);
                $userService->save($user);

                return $this->json(['message' => 'User successfully registered'], Response::HTTP_CREATED);
            } catch (ValidationException $validationException) {
                return $this->json([
                    'message' => $validationException->getMessage(),
                    'errors' => $validationException->getErrors(),
                ], Response::HTTP_BAD_REQUEST);
            } catch (AuthenticationExceptionInterface|UploadedFileException $exception) {
                return $this->json(['errors' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
            }
        }
        $errors = FormErrorExtractor::getErrorsFromForm($form);

        return $this->json(['form_errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}

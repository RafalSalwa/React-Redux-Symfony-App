<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

readonly final class UserValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(UserInterface $user): ?array
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $this->formatValidationErrors($errors);
        }

        return null;
    }

    private function formatValidationErrors(ConstraintViolationListInterface $errors): array
    {
        $formattedErrors = [];
        foreach ($errors as $error) {
            $formattedErrors[] = [
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }

        return ['errors' => $formattedErrors];
    }
}

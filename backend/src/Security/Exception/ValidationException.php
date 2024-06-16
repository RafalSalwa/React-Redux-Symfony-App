<?php

namespace App\Security\Exception;

class ValidationException extends \Exception
{
    private array $errors;

    public function withErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
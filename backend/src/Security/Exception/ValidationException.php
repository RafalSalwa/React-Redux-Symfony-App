<?php

declare(strict_types=1);

namespace App\Security\Exception;

use Exception;

final class ValidationException extends Exception
{
    private array $errors = [];

    public function withErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

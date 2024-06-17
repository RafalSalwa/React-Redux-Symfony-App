<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use function count;

final class ImageCountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (0 === count($value)) {
            return;
        }

        if (count($value) >= $constraint->limit) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ limit }}', $constraint->limit)
            ->addViolation();
    }
}

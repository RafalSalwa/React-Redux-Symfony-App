<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageCountValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint): void
    {
        if (0 === count($value)) {
            return;
        }

        if (count($value) < $constraint->limit) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ limit }}', $constraint->limit)
                ->addViolation();
        }
    }
}

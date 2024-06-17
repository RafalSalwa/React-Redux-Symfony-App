<?php

declare(strict_types=1);

namespace App\Form\Utils;

use Symfony\Component\Form\FormInterface;

final class FormErrorExtractor
{
    public static function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if (! $childForm instanceof FormInterface) {
                continue;
            }

            $childErrors = self::getErrorsFromForm($childForm);
            if ([] === $childErrors) {
                continue;
            }

            $errors[$childForm->getName()] = $childErrors;
        }

        return $errors;
    }
}

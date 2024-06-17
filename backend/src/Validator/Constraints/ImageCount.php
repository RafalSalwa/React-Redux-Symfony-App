<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class ImageCount extends Constraint
{
    public $message = 'You must upload at least {{ limit }} images or none.';

    public $limit = 4;
}

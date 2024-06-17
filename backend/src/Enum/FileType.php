<?php

declare(strict_types=1);

namespace App\Enum;

enum FileType: string
{
    case Avatar = 'avatar';
    case Photo = 'photo';
}

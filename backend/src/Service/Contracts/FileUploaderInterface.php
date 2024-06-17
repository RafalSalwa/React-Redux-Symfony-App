<?php

declare(strict_types=1);

namespace App\Service\Contracts;

use App\Enum\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file, string $filename, FileType $type, string $userIdentifier): string;

    public function uploadMultiple(array $uploadedFiles, FileType $type, string $userIdentifier): array;
}

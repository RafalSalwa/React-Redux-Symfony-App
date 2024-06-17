<?php

declare(strict_types=1);

namespace App\Service\FileUpload;

use App\Enum\FileType;
use App\Service\Contracts\FileUploaderInterface;
use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

use function dd;
use function fopen;
use function md5;
use function uniqid;

#[Autoconfigure(tags: ['file_uploader'])]
final readonly class AWSS3 implements FileUploaderInterface
{
    public function __construct(
        private S3Client $s3Client,
        private string $s3Bucket,
        private string $s3Key,
    ) {
    }

    public function upload(UploadedFile $file, string $filename, FileType $type, string $userIdentifier): string
    {
        if ('' === $this->s3Key) {
            return '';
        }

        $result = $this->s3Client->putObject(
            [
                'Bucket' => $this->s3Bucket,
                'Key' => $filename,
                'Body' => fopen($file->getPathname(), 'r'),
                'SourceFile' => $file,
            ],
        );

        return $result['ObjectURL'];
    }

    public function uploadMultiple(array $uploadedFiles, FileType $type, string $userIdentifier): array
    {
        $filesPaths = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $filename = md5(uniqid('', true)).'.'.$uploadedFile->guessExtension();
            $filePath = $this->upload($uploadedFile, $filename, $type, $userIdentifier);
            $filesPaths[] = $filePath;
        }

        return $filesPaths;
    }
}

<?php

namespace App\Service\FileUpload;

use App\Enum\FileType;
use App\Service\Contracts\FileUploaderInterface;
use Aws\S3\S3Client;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Autoconfigure(tags: ['file_uploader'])]
class AWSS3 implements FileUploaderInterface
{
    public function __construct(
        private readonly S3Client $s3Client,
        private readonly string $s3Bucket,
        private readonly string $s3Key,
    ) {
    }

    public function upload(UploadedFile $file, string $filename, FileType $type, string $userIdentifier): string
    {
        if ('' === $this->s3Key) {
            return "";
        }

        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->s3Bucket,
                'Key' => $filename,
                'Body'   => fopen($file->getPathname(), 'rb'),
                'SourceFile' => $file,
            ]);
            return $result['ObjectURL'];
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }
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

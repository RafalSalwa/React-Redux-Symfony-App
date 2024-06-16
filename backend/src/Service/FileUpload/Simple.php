<?php

namespace App\Service\FileUpload;

use App\Enum\FileType;
use App\Exception\UploadedFileException;
use App\Service\Contracts\FileUploaderInterface;
use App\Service\Contracts\UserFilePathProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Autoconfigure(tags: ['file_uploader'])]
final class Simple implements FileUploaderInterface, UserFilePathProviderInterface
{

    public function __construct(
        private string $avatarsDir,
        private string $photosDir,
    ) {
    }

    /**
     * @throws UploadedFileException when file processing fails on move() operation
     */
    public function upload(UploadedFile $file, string $filename, FileType $type, string $userIdentifier): string
    {
        $path = $this->getPath($type, $userIdentifier);
        $file->move($path, $filename);

        $publicPos = strpos($path, 'public');
        if ($publicPos !== false) {
            $relativePath = substr($path, $publicPos + strlen('public'));

            return sprintf('%s/%s', $relativePath, $filename);
        }

        return "";
    }

    public function uploadMultiple(
        array $uploadedFiles,
        FileType $type,
        string $userIdentifier
    ): array {
        $filesPaths = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $filename = md5(uniqid('', true)).'.'.$uploadedFile->guessExtension();
            $filesPaths[] = $this->upload($uploadedFile, $filename, $type, $userIdentifier);
        }

        return $filesPaths;
    }

    private function getPath(FileType $type, string $userIdentifier): string
    {
        $dir = match ($type) {
            FileType::Avatar => $this->avatarsDir,
            FileType::Photo => $this->photosDir,
        };

        return sprintf("%s/%s", $dir, $userIdentifier);
    }
}

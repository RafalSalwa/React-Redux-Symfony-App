<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Photo;
use App\Entity\User;
use App\Enum\FileType;
use App\Exception\UploadedFileException;
use App\Service\Contracts\FileUploaderInterface;
use App\Service\Contracts\UserFilePathProviderInterface;
use Symfony\Component\HttpFoundation\Request;

final class FileUploader
{
    public function __construct(
        private iterable $uploaders,
    ) {
    }

    /**
     * @throws UploadedFileException
     */
    public function processRequestFiles(Request $request, User $user): void
    {
        if (true === $request->files->has('avatar')) {
            $avatarFile = $request->files->get('avatar');
            $filename = md5(uniqid('', true)).'.'.$avatarFile->guessExtension();
            /** @var FileUploaderInterface $uploader */
            foreach ($this->uploaders as $uploader) {
                $path = $uploader->upload($avatarFile, $filename, FileType::Avatar, $user->getUuid());
                if (true === $uploader instanceof UserFilePathProviderInterface) {
                    $user->setAvatar($path);
                }
            }
        }

        if (true === $request->files->has('photos')) {
            $photos = $request->files->get('photos');
            if (count($photos) < 4) {
                throw new UploadedFileException("There should be at least 4 images uploaded or none.");
            }

            foreach ($this->uploaders as $uploader) {
                $filesPaths = $uploader->uploadMultiple(
                    $request->files->get('photos'),
                    FileType::Photo,
                    $user->getUuid()
                );

                if (true === $uploader instanceof UserFilePathProviderInterface) {
                    foreach ($filesPaths as $filename) {
                        $photo = new Photo($filename);
                        $user->addPhoto($photo);
                    }
                }
            }
        }
    }
}

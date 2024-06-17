<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

use function openssl_decrypt;
use function openssl_encrypt;

final readonly class CryptonService
{
    public function __construct(private string $encryptionKey, private string $encryptionIv)
    {
    }

    public function encrypt(string $data): string
    {
        return openssl_encrypt($data, 'aes-256-cbc', $this->encryptionKey, 0, $this->encryptionIv);
    }

    public function decrypt(string $data): string
    {
        return openssl_decrypt($data, 'aes-256-cbc', $this->encryptionKey, 0, $this->encryptionIv);
    }

    public function decryptUser(User $user): void
    {
        $user->setFirstName($this->decrypt($user->getFirstName()));
        $user->setFullName($this->decrypt($user->getFullName()));
        $user->setLastName($this->decrypt($user->getLastName()));
        $user->setEmail($this->decrypt($user->getEmail()));
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Photo;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(className: User::class)]
#[UsesClass(Photo::class)]
final class Test extends TestCase
{
    public function testUserInitialization(): void
    {
        $user = new User();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->getUuid());
        $this->assertInstanceOf(DateTimeImmutable::class, $user->getCreatedAt());
        $this->assertInstanceOf(ArrayCollection::class, $user->getPhotos());
        $this->assertTrue($user->isActive());
    }

    public function testGettersAndSetters(): void
    {
        $user = new User();

        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());

        $user->setFirstName('John');
        $this->assertSame('John', $user->getFirstName());

        $user->setLastName('Doe');
        $this->assertSame('Doe', $user->getLastName());

        $user->setFullName('John Doe');
        $this->assertSame('John Doe', $user->getFullName());

        $user->setPassword('password123');
        $this->assertSame('password123', $user->getPassword());

        $user->setIsActive(false);
        $this->assertFalse($user->isActive());

        $user->setAvatar('path/to/avatar.jpg');
        $this->assertSame('path/to/avatar.jpg', $user->getAvatar());

        $roles = ['ROLE_ADMIN'];
        $user->setRoles($roles);
        $this->assertSame(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testAddAndRemovePhoto(): void
    {
        $user = new User();
        $photo = $this->createMock(Photo::class);
        $photo->expects($this->once())->method('setUser')->with($user);

        $user->addPhoto($photo);
        $this->assertCount(1, $user->getPhotos());
        $this->assertTrue($user->getPhotos()->contains($photo));

        $user->removePhoto($photo);
        $this->assertCount(0, $user->getPhotos());
        $this->assertFalse($user->getPhotos()->contains($photo));
    }

    public function testPrePersist(): void
    {
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');

        $this->assertSame('John Doe', $user->getFullName());
    }

    public function testPreUpdate(): void
    {
        $user = new User();

        $user->preUpdate();
        $this->assertInstanceOf(DateTimeImmutable::class, $user->getUpdatedAt());
    }
}

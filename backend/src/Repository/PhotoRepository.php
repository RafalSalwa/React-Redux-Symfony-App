<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 *
 * @method Photo|null   find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null   findOneBy(array $criteria, array $orderBy = null)
 * @method array<Photo> findAll()
 * @method array<Photo> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }
}

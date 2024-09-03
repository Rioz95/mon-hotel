<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Room>
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    /**
     * Retourne toutes les chambres pour une catégorie donnée.
     *
     * @param Category $category
     * @return Room[]
     */
    public function findByCategory(Category $category)
    {
        return $this->createQueryBuilder('r')
            ->where('r.category = :category')
            ->setParameter('category', $category)
            ->orderBy('r.type', 'ASC') // Optionnel: tri par type de chambre
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les chambres par type et catégorie.
     *
     * @param string $type
     * @param Category $category
     * @param int $limit
     * @return Room[]
     */
    public function findByTypeAndCategory(string $type, Category $category, int $limit = 3)
    {
        return $this->createQueryBuilder('r')
            ->where('r.type = :type')
            ->andWhere('r.category = :category')
            ->setParameter('type', $type)
            ->setParameter('category', $category)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}

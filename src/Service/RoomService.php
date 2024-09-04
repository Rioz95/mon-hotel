<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Repository\RoomRepository;

class RoomService
{
    private $roomRepository;
    private $categoryRepository;

    public function __construct(RoomRepository $roomRepository, CategoryRepository $categoryRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getRooms(int $limit = 3)
    {
        $categories = $this->categoryRepository->findAll();
        $allRooms = [];

        foreach ($categories as $category) {
            $types = $this->roomRepository->createQueryBuilder('r')
                ->select('r.type')
                ->where('r.category = :category')
                ->setParameter('category', $category)
                ->distinct()
                ->getQuery()
                ->getResult();

            foreach ($types as $type) {
                $typeName = $type['type'];
                $rooms = $this->roomRepository->findByTypeAndCategory($typeName, $category);

                if (!empty($rooms)) {
                    foreach ($rooms as $room) {
                        $allRooms[] = $room;
                        if (count($allRooms) >= $limit) {
                            return array_slice($allRooms, 0, $limit);
                        }
                    }
                }
            }
        }

        return array_slice($allRooms, 0, $limit);
    }
}

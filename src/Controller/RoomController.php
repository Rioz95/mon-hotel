<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $roomRepository;
    private $categoryRepository;

    public function __construct(RoomRepository $roomRepository, CategoryRepository $categoryRepository)
    {
        $this->roomRepository = $roomRepository;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/rooms', name: 'rooms')]
    public function index(): Response
    {
        // Récupérer toutes les catégories
        $categories = $this->categoryRepository->findAll();

        // Préparer un tableau pour stocker les chambres par catégorie
        $roomsByCategory = [];

        foreach ($categories as $category) {
            // Récupérer les types de chambres pour la catégorie
            $types = $this->roomRepository->createQueryBuilder('r')
                ->select('r.type')
                ->where('r.category = :category')
                ->setParameter('category', $category)
                ->distinct()
                ->getQuery()
                ->getResult();

            // Préparer les chambres par type pour chaque catégorie
            $roomsByCategory[$category->getName()] = [
                'category' => $category,
                'rooms' => []
            ];

            foreach ($types as $type) {
                $typeName = $type['type']; // Assurer que le type est une chaîne de caractères
                $rooms = $this->roomRepository->findByTypeAndCategory($typeName, $category);

                if (!empty($rooms)) {
                    $roomsByCategory[$category->getName()]['rooms'][$typeName] = $rooms;
                }
            }
        }

        // Filtrer les catégories vides
        $roomsByCategory = array_filter($roomsByCategory, function ($data) {
            return !empty($data['rooms']);
        });

        return $this->render('room/index.html.twig', [
            'roomsByCategory' => $roomsByCategory,
        ]);
    }
}

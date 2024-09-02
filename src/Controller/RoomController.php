<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/room', name: 'room')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $roomRepository = $entityManager->getRepository(Room::class);
        // Utilisez le Query Builder pour limiter les résultats
        $rooms = $roomRepository->createQueryBuilder('r')
            ->setMaxResults(6) // Limite le nombre de résultats à 3
            ->getQuery()
            ->getResult();
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms
        ]);
    }
}

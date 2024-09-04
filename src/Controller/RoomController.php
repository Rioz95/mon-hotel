<?php

namespace App\Controller;

use App\Service\RoomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    #[Route('/rooms', name: 'rooms')]
    public function index(): Response
    {
        $roomsByCategory = $this->roomService->getRoomsByCategory();

        return $this->render('room/index.html.twig', [
            'roomsByCategory' => $roomsByCategory,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Service\RoomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $roomsToShow = $this->roomService->getRooms();

        return $this->render('home/index.html.twig', [
            'rooms' => $roomsToShow,
        ]);
    }
}

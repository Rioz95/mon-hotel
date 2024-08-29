<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'room')]
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'hero_background_image' => 'url(images/room_hero.jpg)',
            'hero_caption' => 'Explore Our Beautiful Rooms',
            'hero_heading' => 'The Perfect Room for Your Stay',
        ]);
    }

 
}
